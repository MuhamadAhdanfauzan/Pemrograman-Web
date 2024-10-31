<?php

namespace Models;

use Traits\Maintenance;

class Truck {
    use Maintenance;

    private $name;
    private $capacity;

    public function __construct($name, $capacity) {
        $this->name = $name;
        $this->capacity = $capacity;
    }

    public function getInfo() {
        return "Truck Name: " . $this->name . ", Capacity: " . $this->capacity . " tons\n";
    }

    public function toJson() {
        $data = [
            'type' => 'Truck',
            'name' => $this->name,
            'capacity' => $this->capacity,
            'maintenance' => json_decode($this->scheduleMaintenance()) // Menambahkan hasil scheduleMaintenance
        ];
        return json_encode($data);
    }
}
