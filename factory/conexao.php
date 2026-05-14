<?php
class Banco {
    public static $usuario = "root";
    public static $senha = "";
    public static $connect = null;

    private static function Conectar() {
        try {
            if (self::$connect == null) {
                self::$connect = new PDO(
                    'mysql:host=localhost;dbname=dbelmo;charset=utf8mb4',
                    self::$usuario,
                    self::$senha,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            }
        } catch (Exception $ex) {
            echo 'Erro na conexão: ' . $ex->getMessage();
            die;
        }
        return self::$connect;
    }

    public function getConn() {
        return self::Conectar();
    }
}
?>