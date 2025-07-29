<?php
class DB {
    private $conn;
    public $stmt;

    public function __construct() {
        $serverName = getenv('SQLSRV_SERVER') ?: '127.0.0.1';
        $connectionOptions = [
            "Database" => getenv('SQLSRV_DATABASE') ?: 'ICCLdb',
            "Uid" => getenv('SQLSRV_USER') ?: 'iccldbuser',
            "PWD" => getenv('SQLSRV_PASSWORD') ?: 'JqewefqxSKHXisQ',
            "Encrypt" => 1,
            "TrustServerCertificate" => 1,
            "CharacterSet" => 'UTF-8'
        ];

        $this->conn = sqlsrv_connect($serverName, $connectionOptions);
        if ($this->conn === false) {
            error_log('SQL Server connection failed: ' . print_r(sqlsrv_errors(), true));
            die('Database connection failed.');
        }
    }

    public function query($sql, $params = []) {
        $this->stmt = sqlsrv_query($this->conn, $sql, $params);
        if ($this->stmt === false) {
            error_log('Query failed: ' . print_r(sqlsrv_errors(), true));
        }
        return $this->stmt;
    }

    public function fetchObject() {
        if (!$this->stmt) {
            return false;
        }
        return sqlsrv_fetch_object($this->stmt);
    }

    public function fieldMetadata() {
        if (!$this->stmt) {
            return false;
        }
        return sqlsrv_field_metadata($this->stmt);
    }

    public function free() {
        if ($this->stmt) {
            sqlsrv_free_stmt($this->stmt);
            $this->stmt = null;
        }
    }

    public function close() {
        $this->free();
        if ($this->conn) {
            sqlsrv_close($this->conn);
            $this->conn = null;
        }
    }

    public function getConn() {
        return $this->conn;
    }
}

$DB = new DB();
?>
