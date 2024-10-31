<?php

namespace Models;

use Traits\Maintenance;

class Bike extends Vehicle {
    use Maintenance;

    private $fuel;

    public function __construct($name, $speed, $fuel = "Pertamax") {
        parent::__construct($name, $speed);
        $this->fuel = $fuel;
    }

    public function fuelType() {
        return "Fuel type: " . $this->fuel . "\n";
    }

    public function toJson() {
        $data = [
            'type' => 'Bike',
            'name' => $this->name,
            'speed' => $this->speed,
            'fuel' => $this->fuel,
            'maintenance' => json_decode($this->scheduleMaintenance()) // Menambahkan hasil scheduleMaintenance
        ];
        return json_encode($data);
    }
}
