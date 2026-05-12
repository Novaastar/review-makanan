<?php

class Database
{
    private $conn;

    public function connect()
    {
        $this->conn = new mysqli(
            "localhost",
            "root",
            "",
            "db_makanan"
        );

        if ($this->conn->connect_error) {
            die("Koneksi gagal");
        }

        return $this->conn;
    }
}
