<?php
class conexao {
    public static $usuario = "root";
    public static $senha = "";
    public static $connect = null;

    private static function Conectar() {
        try {
            if (conexao::$connect == null) {
                conexao::$connect = new PDO(
                    'mysql:host=localhost;dbname=dbelmo;charset=utf8mb4',
                    conexao::$usuario,
                    conexao::$senha,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            }
        } catch (Exception $ex) {
            echo 'Erro na conexão: ' . $ex->getMessage();
            die;
        }
        return conexao::$connect;
    }

    public function getConn() {
        return conexao::Conectar();
    }
}
?>