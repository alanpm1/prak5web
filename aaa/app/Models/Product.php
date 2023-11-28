<?php

namespace app\Models;

include "app/Config/DatabaseConfig.php";

use app\Config\DatabaseConfig;
use mysqli;

class Product extends DatabaseConfig
{
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database_name, $this->port);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // method menampilkan semua data
    public function findAll()
    {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // method menampilkan data berdasarkan id
    public function findById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stat = $this->conn->prepare($sql);
        $stat->bind_param("i", $id);
        $stat->execute();
        $result = $stat->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data = $row;
        }
        return $data;
    }

    // fungsi input data
    public function create($data)
    {
        $productName = $data["product_name"];
        $query = "INSERT INTO products (product_name) VALUES (?)";
        $stat = $this->conn->prepare($query);
        $stat->bind_param("s", $productName);
        $stat->execute();
    }

    // fungsi update data dengan id
    public function update($id, $data)
    {
        $productName = $data["product_name"];
        $query = "UPDATE products SET product_name = ? WHERE id = ?";
        $stat = $this->conn->prepare($query);
        $stat->bind_param("si", $productName, $id);
        $stat->execute();
    }

    // fungsi delete data dengan id
    public function destroy($id)
    {
        $query = "DELETE FROM products WHERE id = ?";
        $stat = $this->conn->prepare($query);
        $stat->bind_param("i", $id);
        $stat->execute();
    }

    // pastikan untuk tidak menutup koneksi di sini
}
