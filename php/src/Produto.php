<?php 
require_once __DIR__ . "/util.php";
require_once __DIR__ . "/Banco.php";

class Produto {
    private const ATRIBUTOS = [
        "id",
        "estoque",
        "preco",
        "peso",
        "nome",
        "marca",
        "categoria",
        "descricao",
        "vencimento",
        "condicao",
        "frete_gratis",
        "criado_em",
        "modificado_em",
    ];

    private const DATETIMES = ["modificado_em", "criado_em"];
    private const IMUTAVEIS = ["modificado_em", "criado_em", "id"];
    
    public const FILTROS_PERMITIDOS = [
        "nome",
        "marca",
        "categoria",
        "preco",
        "preco_min",
        "preco_max",
        "criado_em",
        "criado_em_min",
        "criado_em_max"
    ];

    public int $id;
    public int $estoque;
    public float $preco;
    public float $peso;
    public string $nome;
    public string $marca;
    public string $categoria;
    public string $descricao;
    public string $vencimento;
    public string $condicao;
    public bool $frete_gratis;
    public DateTime $criado_em;
    public DateTime $modificado_em;


    function __construct($arr){
        foreach ($arr as $chave => $valor){
            if ( in_array($chave, self::ATRIBUTOS) ) {
                if ( in_array($chave, self::DATETIMES) ) {
                    $this->$chave = date_create_from_format("d/m/Y H:i:s", $valor);
                }
                else $this->$chave = $valor;
            }
        }
    }

    function insert(): int {
        if ( isset($this->id) ) throw new BancoException("Já existe um produto com esse id!");
        
        // Constroi um array com os atributos da tabela usando os atributos desse objeto
        // Filtra os atributos que nao estao em $atributos ou estao em $imutaveis
        $nomes = [];
        $valores = [];
        foreach ($this->atributos_banco() as [$nome, $valor]) {
            $nomes[] = $nome;
            $valores[] = $valor;
        }
        
        // Crias as strings com os atributos e as interrogacoes
        $interrogacoes = implode(",", array_map(fn () => "?", $nomes));
        $colunas = implode(",", $nomes);
        
        return Banco::insert("INSERT INTO produtos ($colunas) VALUES ($interrogacoes)", $valores);
    }
    
    
    function carregar(): bool {
        $resultado = Banco::select("SELECT * FROM produtos WHERE id = ?", [$this->id], true);
        if (!$resultado) throw new BancoException("Nao foi possivel carregar o produto: ID $this->id nao existe!");
        $resultado = $resultado[0];

        foreach ($resultado as $chave => $valor) {
            if (property_exists($this, $chave) && $valor !== null) {
                if ( in_array($chave, self::DATETIMES) ) {
                    $this->$chave = date_create_from_format("Y-m-d H:i:s", $valor);
                } 
                else $this->$chave = $valor;
            }
        }
        return true;
    }
    
    function update(): bool {
        if ( !isset($this->id) ) throw new BancoException("Id nulo, impossível atualizar");

        $substrings = [];
        $valores = [];
        foreach ($this->atributos_banco() as [$nome, $valor]) {
            $substrings[] = "$nome = ?";
            $valores[] = $valor;
        }
        $valores[] = $this->id;
        
        $q = "UPDATE produtos SET\n " . implode(",\n ", $substrings) . "\n WHERE id = ?";

        return Banco::update($q, $valores);
    }


    function deletar(): int {
        return Banco::delete("DELETE FROM produtos WHERE id = ?", [$this->id]);
    }


    function atributos_banco(): Generator {
        foreach (get_object_vars($this) as $chave => $valor) {
            if ( !in_array($chave, self::ATRIBUTOS) || in_array($chave, self::IMUTAVEIS) ) continue;
            yield [$chave, $valor];
        }
    }


    static function insereTeste($quantidade){
        $condicoes = ["Novo", "Usado", "Recondicionado"];
        $produtos = [
            "Mouse Óptico USB",
            "Teclado Mecânico RGB",
            "Monitor 24 Polegadas Full HD",
            "Notebook 15.6'' Intel i5",
            "Headset Gamer Surround",
            "Cadeira Ergonômica de Escritório",
            "Smartphone 128GB",
            "Impressora Multifuncional Wi-Fi",
            "SSD 512GB NVMe",
            "Roteador Dual Band AC1200",
            "Carregador Portátil 10000mAh",
            "Fonte 500W 80 Plus Bronze",
            "Placa de Vídeo RTX 3060",
            "Processador Ryzen 5 5600G",
            "Memória RAM 16GB DDR4",
        ];
        $categorias = [
                "Periféricos",
                "Computadores e Notebooks",
                "Armazenamento",
                "Redes e Conectividade",
                "Áudio e Vídeo",
                "Componentes de Hardware",
                "Acessórios",
                "Móveis e Suportes",
                "Energia e Baterias",
                "Dispositivos Móveis"
        ];
        $marcas = [
            "Logitech",
            "Razer",
            "Dell",
            "HP",
            "Lenovo",
            "Corsair",
            "Asus",
            "Acer",
            "Samsung",
            "Kingston",
        ];

        // Gera produtos com dados aleatorios
        for ($i=0; $i<$quantidade; $i++){
            $campos = [
                "nome" => $produtos[array_rand($produtos)],
                "marca" => $marcas[array_rand($marcas)],
                "categoria" => $categorias[array_rand($categorias)],
                "descricao" => rand(1, 10) <= 8 ? str_shuffle(str_repeat("qwerty uiopasd fghjklzx cvbnm", rand(0, 30))) : "",
                "preco" => rand(100, 10000000) / 100,
                "estoque" => rand(1, 5000),
                "peso" => rand(1, 500) / 10,
                "condicao" => $condicoes[array_rand($condicoes)],
                "vencimento" => date("Y-m-d", rand(time(), strtotime("+5 years") )),
            ];
            if (rand(1, 2) > 1) $campos["frete_gratis"] = 1;
            
            $p = new Produto($campos);
            $p->insert();
        }
    }


    static function categorias(): array{
        return Banco::unique("categoria");
    }


    static function marcas(): array{
        return Banco::unique("marca");
    }


    static function quantidade_total($filtros = []): int{
        // Cria as strings para os filtros e bota os valores em um array
        [$subq, $filtro_valores] = self::preparar_filtros($filtros);
        
        $resultado = Banco::select("SELECT COUNT(*) FROM produtos ".$subq, $filtro_valores);

        return $resultado[0][0] ?? 0;
    }

    
    static function preparar_filtros(array $filtros) {
        $filtro_strings = [];
        $filtro_valores = [];
        $filtros_compostos = [];
        $string = "";

        foreach ($filtros as $chave => $valor) {
            if (!$valor || !in_array($chave, self::FILTROS_PERMITIDOS)) continue;

            if (str_ends_with($chave, "_min") || str_ends_with($chave, "_max")){
                $minmax = substr($chave, strlen($chave) - 3);
                $chave = substr($chave, 0, strlen($chave) - 4);
                $filtros_compostos[$chave][$minmax] = $valor;
            }
            else {
                $filtro_strings[] = "$chave LIKE ?";
                $filtro_valores[] = "%$valor%";
            }
        }

        foreach ($filtros_compostos as $chave => $arr) {
            $min = ($arr["min"]) ?? 0;
            $max = ($arr["max"]) ?? 2147483647;
            $filtro_strings[] = "$chave BETWEEN ? AND ?";
            array_push($filtro_valores, $min, $max);
        }


        $string = ($filtro_strings) ? "WHERE " . implode("\nAND ", $filtro_strings) : "";

        return [$string, $filtro_valores];
    }


    static function get_produtos(int $offset, int $quantidade, array $filtros=[]): array{
        $q = "SELECT id, nome, preco, estoque, categoria, marca FROM produtos\n";

        // Cria as strings para os filtros e bota os valores em um array
        [$subq, $filtro_valores] = self::preparar_filtros($filtros);
        
        $q .= $subq;
        $q .= "\nLIMIT $quantidade OFFSET $offset";

        $result = Banco::select($q, $filtro_valores, true);
        $produtos = array_map(fn($i) => new Produto($i), $result); 
        return $produtos;
    }

    static function remover_todos(){
        Banco::delete("DELETE FROM produtos");
    }
}
