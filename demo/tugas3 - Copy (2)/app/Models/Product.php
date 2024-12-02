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

    // Menambahkan prefix URL ke path gambar
    private function formatImageUrl($imagePath) 
    {
        $baseUrl = "http://localhost/uploads/"; // Ganti sesuai lokasi penyimpanan gambar
        return $baseUrl . $imagePath;
    }

    // Mendapatkan semua produk
    public function findAll() 
    {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($row['image_url'])) {
                    $row['image_url'] = $this->formatImageUrl($row['image_url']); // Format URL gambar
                }
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
                if (!empty($row['image_url'])) {
                    $row['image_url'] = $this->formatImageUrl($row['image_url']); // Format URL gambar
                }
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
        $image = $data['image_url']; // Menggunakan image_url untuk menyimpan path gambar
        $query = "INSERT INTO products (product_name, price, image_url) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false; // Jika persiapan statement gagal
        }

        $stmt->bind_param("sds", $productName, $price, $image);
        $result = $stmt->execute();

        return $result; // Return keberhasilan atau kegagalan
    }

    // Memperbarui produk
    public function update($data, $id) 
    {
        $productName = $data["product_name"];
        $price = $data["price"];
        $image = $data["image_url"]; // Menggunakan image_url untuk menyimpan path gambar
        $query = "UPDATE products SET product_name = ?, price = ?, image_url = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false; // Jika persiapan statement gagal
        }

        $stmt->bind_param("sdsi", $productName, $price, $image, $id);
        $result = $stmt->execute();

        return $result; // Return keberhasilan atau kegagalan
    }

    // Menghapus produk berdasarkan ID
    public function delete($id) 
    {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        return $result; // Return keberhasilan atau kegagalan
    }

    public function __destruct() 
    {
        $this->conn->close();
    }
}
