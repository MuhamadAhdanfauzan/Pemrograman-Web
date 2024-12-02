<?php 

namespace app\Controller;

include "app/Traits/ApiResponseFormatter.php";
include "app/Models/Product.php";

use app\Models\Product;
use app\Traits\ApiResponseFormatter;

class ProductController 
{
    use ApiResponseFormatter;

    // Mendapatkan semua produk
    public function index() 
    {
        $productModel = new Product();
        $response = $productModel->findAll();
        return $this->apiResponse(200, "success", $response);
    }

    // Mendapatkan produk berdasarkan ID
    public function getById($id) 
    {
        $productModel = new Product();
        $response = $productModel->findById($id);
        return $this->apiResponse(200, "success", $response);
    }

    // Menambahkan produk baru
    public function insert() 
    {
        // Menangani input JSON
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);
        
        // Validasi input JSON
        if (json_last_error()) {
            return $this->apiResponse(400, "Error: invalid input", null);
        }

        // Validasi file gambar
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $imagePath = 'uploads/' . $imageName;

            // Validasi ekstensi gambar
            $imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedTypes)) {
                return $this->apiResponse(400, "Error: Invalid image format. Only JPG, JPEG, PNG, and GIF allowed.", null);
            }

            // Validasi ukuran gambar (max 5MB)
            if ($_FILES['image']['size'] > 5000000) {
                return $this->apiResponse(400, "Error: File too large. Maximum size is 5MB.", null);
            }

            // Memindahkan gambar ke folder yang dituju
            if (!move_uploaded_file($imageTmpPath, $imagePath)) {
                return $this->apiResponse(400, "Error: Failed to upload image.", null);
            }
            
            // Menyimpan produk ke database
            $productModel = new Product();
            $response = $productModel->create([
                "product_name" => $inputData['product_name'],
                "price" => $inputData['price'],
                "image_url" => $imagePath // Menyimpan path gambar
            ]);

            return $this->apiResponse(200, "success", $response);
        } else {
            return $this->apiResponse(400, "Error: Image upload failed", null);
        }
    }

    // Memperbarui produk berdasarkan ID
    public function update($id) 
    {
        // Menangani input JSON
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        // Validasi input JSON
        if (json_last_error()) {
            return $this->apiResponse(400, "Error: invalid input", null);
        }

        // Memproses file gambar jika ada
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $imagePath = 'uploads/' . $imageName;

            // Validasi ekstensi gambar
            $imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedTypes)) {
                return $this->apiResponse(400, "Error: Invalid image format. Only JPG, JPEG, PNG, and GIF allowed.", null);
            }

            // Validasi ukuran gambar (max 5MB)
            if ($_FILES['image']['size'] > 5000000) {
                return $this->apiResponse(400, "Error: File too large. Maximum size is 5MB.", null);
            }

            // Memindahkan gambar ke folder yang dituju
            if (!move_uploaded_file($imageTmpPath, $imagePath)) {
                return $this->apiResponse(400, "Error: Failed to upload image.", null);
            }
        } else {
            // Jika gambar tidak di-upload, gunakan gambar yang ada
            $imagePath = $inputData['image_url']; // Menyimpan gambar lama
        }

        // Memperbarui data produk di database
        $productModel = new Product();
        $response = $productModel->update([
            "product_name" => $inputData['product_name'],
            "price" => $inputData['price'],
            "image_url" => $imagePath
        ], $id);

        return $this->apiResponse(200, "success", $response);
    }

    // Menghapus produk berdasarkan ID
    public function delete($id) 
    {
        $productModel = new Product();
        $response = $productModel->delete($id);
        return $this->apiResponse(200, "success", $response);
    }
}
