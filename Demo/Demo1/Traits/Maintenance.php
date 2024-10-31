<?php

namespace Traits;

trait Maintenance {
    public function scheduleMaintenance() {
        $data = [
            'message' => $this->name . " has been scheduled for maintenance."
        ];

        // Mengembalikan respons dalam format JSON
        return json_encode($data);
    }
}
