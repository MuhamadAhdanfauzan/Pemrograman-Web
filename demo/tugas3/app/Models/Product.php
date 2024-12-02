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
        $this->conn = new mysqli(
            $this->host, 
            $this->user, 
            $this->password, 
            $this->database_name, 
            $this->port
        );

        if ($this->conn->connect_error) {
            die("Connection Failed: " . $this->conn->connect_error);
        }
    }

    // Mendapatkan semua produk
    public function findAll() 
    {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }

    // Mendapatkan produk berdasarkan ID
    public function findById($id) 
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    // Menambahkan produk baru
    public function create($data) 
    {
        $productName = $data['product_name'];
        $price = $data['price'];
        $image = $data['image']; // Menggunakan kolom 'image' untuk menyimpan path gambar
        $query = "INSERT INTO products (product_name, price, image) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Pastikan bind parameter sesuai dengan jenis data
        if ($stmt === false) {
            return false; // Jika persiapan statement gagal
        }

        $stmt->bind_param("sds", $productName, $price, $image);
        $result = $stmt->execute();

        // Menambahkan pengecekan untuk keberhasilan eksekusi
        if ($result) {
            return true;
        } else {
            return false; // Jika eksekusi gagal
        }
    }

    // Memperbarui produk
    public function update($data, $id) 
    {
        $productName = $data["product_name"];
        $price = $data["price"];
        $image = $data["image"]; // Menggunakan kolom 'image' untuk menyimpan path gambar
        $query = "UPDATE products SET product_name = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false; // Jika persiapan statement gagal
        }

        $stmt->bind_param("sdsi", $productName, $price, $image, $id);
        $result = $stmt->execute();

        if ($result) {
            return true;
        } else {
            return false; // Jika eksekusi gagal
        }
    }

    // Menghapus produk berdasarkan ID
    public function delete($id) 
    {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        // Mengecek apakah produk berhasil dihapus
        return $result;
    }

    public function __destruct() 
    {
        $this->conn->close();
    }
}
