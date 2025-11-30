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
    public string $marca = "";
    public string $categoria = "";
    public string $descricao;
    public string $vencimento;
    public string $condicao;
    public int $frete_gratis;
    public DateTime $criado_em;
    public DateTime $modificado_em;


    /**
     * Construtor da classe Produto.
     * Recebe um array associativo e preenche os atributos do objeto.
     * @param array $arr array associativo com os dados do produto
     */
    function __construct($arr) {
        foreach ($arr as $chave => $valor) {
            // Verifica se a chave é um atributo valido
            if ( in_array($chave, self::ATRIBUTOS) ) {
                if ( in_array($chave, self::DATETIMES) ) {
                    $this->$chave = date_create_from_format("d/m/Y H:i:s", $valor);
                }
                else if ($chave == "vencimento") {
                    $t = date_create_from_format("d/m/Y", $valor);
                    if ($t) $valor = date_format($t, "Y-m-d");
                    if ($valor != "") $this->$chave = $valor;
                }
                else $this->$chave = $valor;
            }
        }
        
        $this->frete_gratis = isset($this->frete_gratis) ? 1 : 0;
    }


    /**
     * Insere esse produto no banco de dados
     * @return int ID do produto inserido
     * @throws BancoException Se o produto já tiver um ID definido
     */
    function insert(): int {
        if ( isset($this->id) ) throw new BancoException("Já existe um produto com esse id!");
        
        // Constroi um array com os atributos desse objeto para inserir no banco
        // Filtra os atributos que nao devem ser inseridos
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
    
    
    /**
     * Carrega os dados do produto do banco de dados usando o ID
     * @return bool true se o carregamento foi bem-sucedido
     * @throws BancoException Se o produto nao existir no banco
     */
    function carregar(): bool {
        $resultado = Banco::select("SELECT * FROM produtos WHERE id = ?", [$this->id], true);
        if (!$resultado) throw new BancoException("Nao foi possivel carregar o produto: ID $this->id nao existe!");
        $resultado = $resultado[0];

        // Preenche os atributos do objeto com os dados do banco
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
    

    /**
     * Atualiza os dados do produto no banco de dados
     * @return bool true se a atualizacao foi feita com sucesso 
     * @throws BancoException Se o ID nao estiver definido
     */
    function update(): bool {
        if ( !isset($this->id) ) throw new BancoException("Id nulo, impossível atualizar");

        $substrings = [];
        $valores = [];
        foreach ($this->atributos_banco() as [$nome, $valor]) {
            $substrings[] = "$nome = ?";
            $valores[] = $valor;
        }
        $valores[] = $this->id;  // Adiciona o ID no final para o WHERE
        
        $q = "UPDATE produtos SET\n " . implode(",\n ", $substrings) . "\n WHERE id = ?";

        return Banco::update($q, $valores);
    }


    /**
     * Deleta o produto do banco de dados
     * @return int Numero de linhas dletadas (deve ser 1)
     */
    function deletar(): int {
        return Banco::delete("DELETE FROM produtos WHERE id = ?", [$this->id]);
    }


    /**
     * Generator que retorna os atributos que podem ser salvos no banco
     * @return Generator Retorna arrays [nome, valor] para cada atributo valido
     */
    function atributos_banco(): Generator {
        foreach (get_object_vars($this) as $chave => $valor) {
            // Filtra atributos que nao deve ser atualizados pois o banco calcula automaticamente
            if ( !in_array($chave, self::ATRIBUTOS) || in_array($chave, self::IMUTAVEIS) ) continue;
            yield [$chave, $valor];
        }
    }


    /**
     * Insere produtos de teste no banco de dados
     * @param int $quantidade Quantidade de produtos a serem inseridos
     */
    static function insereTeste(int $quantidade): void {
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
                "descricao" => rand(1, 10) <= 8 ? str_shuffle(str_repeat("qwerty uiopasd fghjklzx cvbnm", rand(0, 30))) : "", // 80% de chance de ter descricao
                "preco" => rand(100, 10000000) / 100, // Preço entre R$ 1,00 e R$ 100.000,00
                "estoque" => rand(1, 5000),
                "peso" => rand(1, 500) / 10, // Peso entre 0,1kg e 50kg
                "condicao" => $condicoes[array_rand($condicoes)],
                "vencimento" => date("Y-m-d", rand(time(), strtotime("+3 years") )), // Data de vencimento aleatória entre hoje e 3 anos no futuro
            ];
            if (rand(1, 2) > 1) $campos["frete_gratis"] = 1; // 50% de chance de ter frete gratis
            
            $p = new Produto($campos);
            $p->insert();
        }
    }


    /**
     * Busca todas as categorias do banco
     * @return array array com os nomes das categorias
     */
    static function categorias(): array {
        return Banco::unique("categoria");
    }


    /**
     * Busca todas as marcas do banco
     * @return array array com os nomes das marcas
     */
    static function marcas(): array {
        return Banco::unique("marca");
    }


    /**
     * Retorna a quantidade total de produtos ou a quantidade total filtrada
     * @param array $filtros array associativo com filtros
     * @return int Numero total de produtos que atendem aos filtros
     */
    static function quantidade_total(array $filtros = []): int {
        [$subq, $filtro_valores] = self::preparar_filtros($filtros);
        $resultado = Banco::select("SELECT COUNT(*) FROM produtos ".$subq, $filtro_valores);
        return $resultado[0][0] ?? 0;
    }

    
    /**
     * Prepara os filtros para usar nos queries
     * @param array $filtros array associativo com os filtros
     * @return array array com o subquery WHERE e os valores
    */
    static function preparar_filtros(array $filtros): array {
        $filtro_strings = [];
        $filtro_valores = [];
        $filtros_compostos = [];

        foreach ($filtros as $chave => $valor) {
            // Ignora filtros vazios ou não permitidos
            if (!$valor || !in_array($chave, self::FILTROS_PERMITIDOS)) continue;

            // Detecta filtros compostos (ex: preco_min, preco_max)
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

        // USa BETWEEN para filtrs compostso
        foreach ($filtros_compostos as $chave => $arr) {
            $min = ($arr["min"]) ?? 0;
            $max = ($arr["max"]) ?? 2147483647;
            $filtro_strings[] = "$chave BETWEEN ? AND ?";
            array_push($filtro_valores, $min, $max);
        }

        // Constroi o WHERE se tiver filtros
        $string = ($filtro_strings) ? "WHERE " . implode("\nAND ", $filtro_strings) : "";

        return [$string, $filtro_valores];
    }


    /**
     * Retorna uma quantidade de produtos com ou sem filtros
     * @param int $offset De
     * @param int $quantidade Quantidade de produtos para retornar
     * @param array $filtros Filtros para aplicar na busca
     * @return array array de objetos Produto
     */
    static function get_produtos(int $offset, int $quantidade, array $filtros=[]): array{
        $q = "SELECT id, nome, preco, estoque, categoria, marca FROM produtos\n";

        [$subq, $filtro_valores] = self::preparar_filtros($filtros);
        
        $q .= $subq;
        $q .= "\nLIMIT $quantidade OFFSET $offset";

        $result = Banco::select($q, $filtro_valores, true);
        // Converte arrays associativos em objetos Produto
        $produtos = array_map(fn($i) => new Produto($i), $result); 
        return $produtos;
    }

    /**
     * Remove todos os produtos do banco de dados
     */
    static function remover_todos(): void {
        Banco::delete("DELETE FROM produtos");
    }
}
