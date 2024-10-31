<?php

namespace Models;

abstract class Vehicle {
    protected $name;
    protected $speed;

    public function __construct($name, $speed) {
        $this->name = $name;
        $this->speed = $speed;
    }

    // Abstract method yang harus diimplementasikan oleh kelas turunan
    abstract public function fuelType();

    public function getInfo() {
        return "Name: " . $this->name . ", Speed: " . $this->speed . " km/h\n";
    }
}
