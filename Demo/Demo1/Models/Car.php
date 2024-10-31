<?php

namespace Models;

include "Traits/Maintenance.php";

use Traits\Maintenance;

class Car extends Vehicle {
    use Maintenance;

    private $fuel;

    public function __construct($name, $speed, $fuel = "Diesel") {
        parent::__construct($name, $speed);
        $this->fuel = $fuel;
    }

    public function fuelType() {
        return "Fuel type: " . $this->fuel . "\n";
    }

    public function toJson() {
        $data = [
            'type' => 'Car',
            'name' => $this->name,
            'speed' => $this->speed,
            'fuel' => $this->fuel,
            'maintenance' => $this->scheduleMaintenance()
        ];
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    // Magic method __toString untuk menampilkan informasi tentang objek Car dalam format JSON
    public function __toString() {
        $data = [
            'message' => "This is a Car named " . $this->name . " with speed " . $this->speed . " km/h."
        ];
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
