<?php 

namespace Framework;
use PDO;
use PDOException;
use Exception;
class Database {
    public $conn;

    public function __construct($config) {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        try{
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        }
        catch(PDOException $e) {
            throw new Exception("PDO connection failed: {$e->getMessage()}");
        }
    }

    public function query($query, $params = []) {
        try{
            $sth = $this->conn->prepare($query);

            // bind named params
            foreach($params as $param => $value) {
                $sth->bindValue(':' . $param, $value);
            }

            $sth->execute();
            return $sth;
        }
        catch(PDOException $e) {
            throw new Exception("{$e->getMessage()}");
        }
    }
}