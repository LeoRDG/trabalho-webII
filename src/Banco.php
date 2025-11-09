<?php


class Banco {
    private const HOST = "localhost";
    private const USUARIO = "mamp";
    private const SENHA = "root";
    private const BANCO = "web2";
    

    /**
     * Conecta ao banco de dados.
     * @return mysqli|null A conexao com o banco ou null se nao foi possivel conectar.
     */
    private static function conexao (): mysqli {
        $con = new mysqli(self::HOST, self::USUARIO, self::SENHA, self::BANCO);
        mysqli_set_charset($con, "utf8");
        return $con;
    }


    /**
     * Valida o tipo do query, usado antes de madar o query para o banco
     * @param string $query O query
     * @param string $comando_esperado O tipo que o query deve ser: SELECT, INSERT, etc..
     * @return void Nao retorna nada, Cria um novo erro se o uqery nao for valido
     */
    static function validar_query(string $query, string $comando_esperado){
        $comando = strtoupper( strtok($query, " ") );
        $comando_esperado = strtoupper($comando_esperado);

        if ($comando === $comando_esperado) return;

        $msg = "Query deve ser $comando_esperado, não $comando";
        echo $msg;
        throw new InvalidArgumentException($msg);
    }


    /**
     * Roda um query do tipo SELECT no banco de dados
     * @param string $query O query para rodar no banco
     * @param ?array $params Os parametros para colocar no query
     * @return array Um array com o que foi encontrado no select
     */
    static function select (string $query, ?array $params=null): array {
        self::validar_query($query, "select");

        $result = [];
        $con = self::conexao();
        $con->execute_query($query, $params);

        return $result;
    }


    /**
     * Roda um query do tipo INSERT no banco de dados
     * @param string $query O query para rodar no banco
     * @param ?array $params Os parametros para colocar no query
     * @return array Um array com o que foi encontrado no select
     */
    static function insert (string $query, ?array $params=null): bool {
        self::validar_query($query, "insert");
        
        $con = self::conexao();
        $con->execute_query($query, $params);

        return true;
    }

}
