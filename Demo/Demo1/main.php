<?php

require_once 'Models/Vehicle.php';
require_once 'Models/Car.php';
require_once 'Models/Bike.php';
require_once 'Models/Truck.php';
require_once 'Traits/Maintenance.php';

use Models\Car;
use Models\Bike;
use Models\Truck;

// Membuat objek
$car = new Car("Toyota", 180);
$bike = new Bike("Harley", 120);
$truck = new Truck("Volvo", 20);

// Mengumpulkan data dalam format JSON, termasuk hasil dari __toString() untuk Car
$data = [
    'car' => json_decode((string) $car), // Menggunakan __toString() pada Car
    'bike' => json_decode($bike->toJson()), // Menggunakan toJson() pada Bike
    'truck' => json_decode($truck->toJson()) // Menggunakan toJson() pada Truck
];

// Menetapkan header untuk JSON dan menampilkan data JSON
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
