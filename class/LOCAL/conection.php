<?php
class HLSynchlcubasSyncAPI
{
    private $host = 'localhost';
    private $db = 'hlcubassyncapi';
    private $user = 'root';
    private $pass = '';
    private $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
    public function getLastId($table, $primaryKey)
    {
        $query = "SELECT MAX(`$primaryKey`) as last_id FROM `$table`";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['last_id'];
        } else {
            return null;
        }
    }
}
/*
$api = new HLSynchlcubasSyncAPI();
$lastId = $api->getLastId('homelightingproducts', 'idHomeLightingProducts');
echo "The last ID in homelightingproducts is: " . $lastId;*/