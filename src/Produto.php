<?php 

require "Banco.php";

class Produto {
    public int $id;
    public int $estoque;
    public float $preco;
    public float $peso;
    public string $nome;
    public string $marca;
    public string $categoria;
    public string $descricao;
    public string $condicao;
    public string $imagem;
    public bool $frete_gratis;
    public string $criado_em; 
    public DateTime $modificado_em; 


    function __construct($arr){
        foreach ($arr as $chave => $valor){
            if (property_exists($this, $chave)) $this->$chave = $valor;
        }
    }

    function insert(): int {
        if (isset($this->id)) return -1; // Produto ja existe, entao nao inserir;
        
        // Filtra os campos em exclude para que nao sejam inseridos na tabela pois o valor será calculado pelo mysql
        // Carrega os valores dinamicamente a partir dos atributos desse objeto
        $filtered_vars = [];
        $exclude = ["id", "modificado_em", "criado_em"];
        foreach (get_object_vars($this) as $chave => $valor) {
            if (!isset($exclude[$chave])) $filtered_vars[$chave] = $valor;
        }

        // Manualmente adicionar a data
        $filtered_vars["criado_em"] = date_format(new DateTime(), "Y-m-d");

        // Crias as strings com os atributos e as interrogacoes
        $atributos = implode(",", array_keys($filtered_vars) );
        $inters = implode(",", array_map(fn ($i) => "?", $filtered_vars) );

        return Banco::insert("INSERT INTO produtos ($atributos) VALUES ($inters)", array_values($filtered_vars));
    }


    static function get(): array {   
        $resultado = Banco::select("SELECT * FROM produtos", null, true);

        return $resultado;
    }


    static function produtos(): array {
        $produtos = [];
        $q = "SELECT nome, preco, estoque, categoria FROM produtos";
        $result = Banco::select($q, null, true);
        foreach ($result as $p){
            $produtos[] = new Produto($p);
        } 
        return $produtos;
    }


    static function insereTeste($qtd){
        $conds = ["Novo", "Usado", "Recondicionado"];
        $produtos = [
            "Mouse Óptico USB",
            "Teclado Mecânico RGB",
            "Monitor 24 Polegadas Full HD",
            "Notebook 15.6'' Intel i5",
            "Headset Gamer Surround",
            "Cadeira Ergonômica de Escritório",
            "Smartphone 128GB",
            "Tablet Android 10''",
            "Impressora Multifuncional Wi-Fi",
            "HD Externo 1TB",
            "SSD 512GB NVMe",
            "Roteador Dual Band AC1200",
            "Webcam Full HD",
            "Microfone Condensador USB",
            "Caixa de Som Bluetooth",
            "Pendrive 64GB",
            "Carregador Portátil 10000mAh",
            "Fonte 500W 80 Plus Bronze",
            "Placa de Vídeo RTX 3060",
            "Processador Ryzen 5 5600G",
            "Memória RAM 16GB DDR4",
            "Placa-Mãe B550M",
            "Cooler para CPU RGB",
            "Cabo HDMI 2.1 2m",
            "Adaptador USB-C para HDMI",
            "Hub USB 3.0 4 Portas",
            "Leitor de Cartão SD",
            "Controle Bluetooth para PC",
            "Tapete Gamer XXL",
            "Suporte Articulado para Monitor"
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
            "Seagate",
            "TP-Link"
        ];


        for ($i=0;$i<$qtd;$i++){
            $time = mt_rand(1577836800, 1735689600);
            $date = date("Y-m-d", $time);
            $campos = [
                "nome" => $produtos[array_rand($produtos)],
                "marca" => $marcas[array_rand($marcas)],
                "categoria" => $categorias[array_rand($categorias)],
                "descricao" => ($i%2==0) ? "" : "iiwejfiwefjwief jwiefj wiefjiw ejf wiefjnw ijefn wiejfnwiefn wiefnw ienfiwenfwienf eijfn3i4nf4 n3fn3efe",
                "preco" => mt_rand(10000, 12034000) / 1000,
                "estoque" => mt_rand(1, 500),
                "peso" => mt_rand(100, 10000) / 1000,
                "condicao" => $conds[array_rand($conds)],
                "frete_gratis" => 1,
                "criado_em" => $date,
            ];
            
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


    static function quantidade_total(): int{
        $resultado = Banco::select("SELECT COUNT(*) FROM produtos");
        return $resultado[0][0] ?? 0;
    }


    static function get_produtos(int $offset, int $quantidade): array{
        $q = "SELECT id, nome, preco, estoque, categoria FROM produtos LIMIT $quantidade OFFSET $offset";
        $result = Banco::select($q, null, true);
        $produtos = array_map(fn($i) => new Produto($i), $result); 
        return $produtos;
    }
}
