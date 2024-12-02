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
        // Tangkap input JSON
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        // Validasi input JSON
        if (json_last_error()) {
            return $this->apiResponse(400, "Error: invalid input", null);
        }

        // Ambil nama gambar dari input JSON jika ada
        $image = isset($inputData['image']) ? $inputData['image'] : null;

        // Simpan produk ke database
        $productModel = new Product();
        $response = $productModel->create([
            "product_name" => $inputData['product_name'],
            "price" => $inputData['price'],
            "image" => $image // Menyimpan nama file gambar ke database
        ]);

        return $this->apiResponse(200, "success", $response);
    }

    // Memperbarui produk berdasarkan ID
    public function update($id) 
    {
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        if (json_last_error()) {
            return $this->apiResponse(400, "Error: invalid input", null);
        }

        // Ambil nama gambar baru dari input JSON jika ada
        $image = isset($inputData['image']) ? $inputData['image'] : null;

        // Update produk di database
        $productModel = new Product();
        $response = $productModel->update([
            "product_name" => $inputData['product_name'],
            "price" => $inputData['price'],
            "image" => $image // Menyimpan nama file gambar ke database
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
