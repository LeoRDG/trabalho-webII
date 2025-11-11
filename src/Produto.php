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
    public string $caminho_imagem;
    public bool $frete_gratis;
    public DateTime $criado_em; 
    public DateTime $modificado_em; 


    function __construct($arr){
        foreach ($arr as $chave => $valor){
            if (property_exists($this, $chave)) $this->$chave = $valor;
        }
    }

    function insert(): int {
        if (isset($this->id)) return -1; // Produto ja existe entao nao inserir;
        
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

        var_dump($filtered_vars);
        var_dump($atributos);
        var_dump($inters);


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


    static function insereTeste(){
        $conds = ["Novo", "Usado", "Recondicionado"];
        $time = time();
        for ($i=0;$i<50;$i++){
            $time -= $i*86400*23;
            $date = date("Y-m-d", $time);
            $campos = [
                "nome" => "NOME_TESTE$i",
                "marca" => "MARCA_TESTE$i",
                "categoria" => "CAT_TESTE$i",
                "descricao" => "DESC_TESTE$i",
                "preco" => $i*100,
                "estoque" => $i,
                "peso" => $i*sqrt(2),
                "condicao" => $conds[$i%3],
                "frete_gratis" => (int) $i%2,
                "caminho_imagem" => "NOME_TESTE$i.png",
                "criado_em" => $date,
            ];
            
            $chaves = array_keys($campos);
            $t = implode(",", $chaves);
            $inter = array_map(fn($i) => "?", $chaves);
            $inter = implode(",", $inter);
            
            $q = "INSERT INTO `produtos` ($t) VALUES ($inter)";
            Banco::insert($q, array_values($campos));
        }
    }


    static function categorias(): array{
        return Banco::unique("categoria");
    }


    static function marcas(): array{
        return Banco::unique("marca");
    }
}
