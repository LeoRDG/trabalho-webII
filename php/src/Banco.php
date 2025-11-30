<?php

class BancoException extends Exception {
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class Banco {
    private const HOST = "localhost";
    private const USUARIO = "mamp";
    private const SENHA = "root";
    private const BANCO = "Trabalho_webII_Leonardo";
    

    /**
     * Conecta ao banco de dados.
     * @return mysqli A conexao com o banco
     * @throws BancoException Se nao foi possivel conectar ao banco
     */
    private static function conexao (): mysqli {
        try {
            $con = new mysqli(self::HOST, self::USUARIO, self::SENHA, self::BANCO);

            if ($con->connect_error) {
                throw new BancoException("Erro ao conectar ao banco de dados: $con->connect_error (Código: $con->connect_errno)");
            }

            mysqli_set_charset($con, "utf8");
            return $con;

        } catch (mysqli_sql_exception $e) {
            throw new BancoException("Erro ao conectar ao banco de dados: {$e->getMessage()}", $e->getCode(), $e);
        }
    }


    /**
     * Valida o tipo do query, usado antes de madar o query para o banco
     * @param string $query O query
     * @param string $comando_esperado O tipo que o query deve ser: SELECT, INSERT, etc..
     * @return void Nao retorna nada, Cria um novo erro se o uqery nao for valido
     */
    private static function validar_query(string $query, string $comando_esperado){
        // Extrai o primeiro comando da query (SELECT, INSERT, etc.)
        $comando = strtoupper( strtok($query, " ") );
        $comando_esperado = strtoupper($comando_esperado);

        if ($comando === $comando_esperado) return;

        $msg = "Query deve ser $comando_esperado, não $comando";
        throw new BancoException($msg);
    }


    /**
     * Roda um query do tipo SELECT no banco de dados
     * @param string $query O query para rodar no banco
     * @param ?array $params Os parametros para colocar no query
     * @param bool $assoc Usar array associativo?
     * @return array Um array com o que foi encontrado no select
     * @throws BancoException Se houver erro na conexao ou na execucao do query
     */
    static function select (string $query, ?array $params=null, bool $assoc=false): array {
        try {
            self::validar_query($query, "select");

            $con = self::conexao();
            $result = $con->execute_query($query, $params);

            if ($result === false) {
                throw new BancoException("Erro ao executar SELECT: $con->error (Código: $con->errno)");
            }

            $tipo_array = $assoc ? MYSQLI_ASSOC : MYSQLI_NUM;
            
            return $result->fetch_all($tipo_array);
        } catch (BancoException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new BancoException("Erro ao executar SELECT: {$e->getMessage()}", $e->getCode(), $e);
        }
    }


    /**
     * Roda um query do tipo INSERT no banco de dados
     * @param string $query O query para rodar no banco
     * @param ?array $params Os parametros para colocar no query
     * @return int Um inteiro que representa o id dos dados inseridos
     * @throws BancoException Se houver erro na conexao ou na execucao do query
     */
    static function insert (string $query, ?array $params=null): int {
        try {
            self::validar_query($query, "insert");
            
            $con = self::conexao();
            $result = $con->execute_query($query, $params);
            
            if ($result === false) {
                throw new BancoException("Erro ao executar INSERT: $con->error (Código: $con->errno)");
            }
            
            return $con->insert_id;
        }
        catch (BancoException $e) {
            throw $e;
        }
        catch (Exception $e) {
            throw new BancoException("Erro ao executar INSERT: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    /**
     * Roda um query do tipo UPDATE no banco de dados
     * @param string $query O query para rodar no banco
     * @param ?array $params Os parametros para colocar no query
     * @return bool True se o update foi executado com sucesso
     * @throws BancoException Se houver erro na conexao ou na execucao do query
     */
    static function update (string $query, ?array $params=null): bool {
        try {
            self::validar_query($query, "update");
            
            $con = self::conexao();
            $result = $con->execute_query($query, $params);
            
            if ($result === false) {
                throw new BancoException("Erro ao executar UPDATE: $con->error (Código: $con->errno)");
            }
            
            return $result;
        } catch (BancoException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new BancoException("Erro ao executar UPDATE: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    /**
     * Remove dados do banco
     * @param string $query O query para rodar no banco
     * @param ?array $params Os parametros para colocar no query
     * @return int A quantidade de linhas removidas
     * @throws BancoException Se houver erro na conexao ou na execucao do query
     */
    static function delete (string $query, ?array $params=null): int {
        try {
            self::validar_query($query, "delete");
            $con = self::conexao();
            $result = $con->execute_query($query, $params);
            
            if ($result === false) {
                throw new BancoException("Erro ao executar DELETE: $con->error (Código: $con->errno)");
            }
            
            return $con->affected_rows;
        }
        catch (BancoException $e) {
            throw $e;
        }
        catch (Exception $e) {
            throw new BancoException("Erro ao executar DELETE: {$e->getMessage()}", $e->getCode(), $e);
        }
    }


    /**
     * Busca todos os valores unicos de uma coluna
     * @param string $coluna Nome da coluna
     * @return array Array com os valores unicos
     */
    static function unique (string $coluna): array {
        $q = "SELECT $coluna FROM produtos GROUP BY $coluna ORDER BY $coluna";
        $result = self::select($q);
        $result = array_map(fn ($i) => $i[0], $result);
        return $result;
    }
}
