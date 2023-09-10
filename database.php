<?php

class Database
{
    public $hostname;
    public $dbname;

    public   $username;
    private  $password;

    private  $conn;
    public   $connected = false;

    function __construct($hostname, $dbname, $username, $password)
    {
        $this->hostname = $hostname;
        $this->dbname   = $dbname;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    function connect()
    {
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error)
        {
            $this->connected = false;
            return false;
        }
        
        $this->connected = true;
        return true;
    }

    function excute($query, $parameters)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($parameters);
        $result = $stmt->get_result();

        $rows = [];

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return json_encode($rows);
    }
}


?>