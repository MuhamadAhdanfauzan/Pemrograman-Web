<?php

function printNumbers($n) {
    // Pastikan input adalah bilangan bulat positif
    if ($n <= 0) {
        return json_encode(["error" => "Input harus berupa bilangan bulat positif."]);
    }

    // Array untuk menampung hasil
    $result = [];

    // Perulangan dari 1 hingga n
    for ($i = 1; $i <= $n; $i++) {
        // Cek kondisi bilangan sesuai instruksi
        if ($i % 4 === 0 && $i % 6 === 0) {
            $result[] = "Pemrograman Website 2024";
        } elseif ($i % 5 === 0) {
            $result[] = "2024";
        } elseif ($i % 4 === 0 && $i % 6 !== 0) {
            $result[] = "Pemrograman";
        } elseif ($i % 6 === 0 && $i % 4 !== 0) {
            $result[] = "Website";
        } else {
            $result[] = $i;
        }
    }

    // Mengembalikan hasil dalam format JSON
    return json_encode($result, JSON_PRETTY_PRINT);
}

// Contoh penggunaan fungsi
$n = 30; // Anda bisa mengganti nilai n sesuai kebutuhan
header('Content-Type: application/json');
echo printNumbers($n);

?>
