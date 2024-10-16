let expression = ''; // Variabel untuk menyimpan ekspresi perhitungan
let displayExpression = ''; // Variabel untuk menampilkan ekspresi di layar
let resultDisplayed = false; // Variabel untuk menandai apakah hasil sudah ditampilkan

// Fungsi untuk menambahkan nilai ke ekspresi
function appendValue(value) {
    if (resultDisplayed) {
        // Jika hasil ditampilkan, reset ekspresi dan tampilkan nilai baru
        expression = '';
        resultDisplayed = false; // Set ulang status hasil ditampilkan
        enableEqualsButton(); // Enable equals button again
    }

    expression += value; // Menyimpan nilai ke dalam ekspresi
    displayExpression += value; // Menampilkan nilai di layar
    updateDisplay();
}

// Fungsi untuk menambahkan operator perkalian "x" ke ekspresi
function appendMultiply() {
    if (resultDisplayed) {
        displayExpression += expression; // Tambahkan hasil terakhir ke tampilan
        resultDisplayed = false; // Set ulang status hasil ditampilkan
        enableEqualsButton(); // Enable equals button again
    }

    expression += 'x'; // Simpan x di dalam ekspresi
    displayExpression += 'x'; // Tampilkan x di layar
    updateDisplay();
}

// Fungsi untuk operasi berpangkat 
function appendPower() {
    if (resultDisplayed) {
        displayExpression += expression; // Tambahkan hasil terakhir ke tampilan
        resultDisplayed = false; // Set ulang status hasil ditampilkan
        enableEqualsButton(); // Enable equals button again
    }

    expression += '^'; // Simpan ^ di dalam ekspresi
    displayExpression += '^'; // Tampilkan ^ di layar
    updateDisplay();
}

// Fungsi untuk operator bagi
function appendDivision() {
    if (resultDisplayed) {
        displayExpression += expression; // Tambahkan hasil terakhir ke tampilan
        resultDisplayed = false; // Set ulang status hasil ditampilkan
        enableEqualsButton(); // Enable equals button again
    }

    expression += '÷'; // Simpan ÷ di dalam ekspresi
    displayExpression += '÷'; // Tampilkan ÷ di layar
    updateDisplay();
}

// Fungsi untuk membersihkan seluruh ekspresi
function clearAll() {
    expression = '';
    displayExpression = '';
    document.getElementById('result').innerText = '0';
    document.getElementById('operation').innerText = '';
    resultDisplayed = false; // Reset status hasil ditampilkan
    enableEqualsButton(); // Enable equals button
}

// Fungsi untuk menghapus karakter terakhir dari ekspresi
function deleteLast() {
    expression = expression.slice(0, -1);
    displayExpression = displayExpression.slice(0, -1);
    updateDisplay();
}

// Fungsi untuk menghitung hasil dari ekspresi
function calculate() {
    if (expression.trim() === '') {
        // Jika ekspresi kosong, tidak lakukan apa-apa
        return;
    }

    try {
        // Ganti x dengan * dan ^ dengan ** untuk perhitungan
        let calcExpression = expression
            .replace(/x/g, '*')
            .replace(/\^/g, '**')
            .replace(/\÷/g, '/'); // Ganti ÷ dengan /

        let result = eval(calcExpression); // eval mengenali semua operator

        // Memperbarui tampilan dengan hasil
        document.getElementById('result').innerText = result;
        
        // Update display expression to include the previous result
        document.getElementById('operation').innerText = displayExpression + ' = ' + result; // Tampilkan operasi

        // Menyimpan hasil ke variabel ekspresi untuk operasi lanjutan
        expression = result.toString();
        displayExpression = ''; // Reset displayExpression for new input
        resultDisplayed = true; // Menandai bahwa hasil sudah ditampilkan
        disableEqualsButton(); // Disable equals button after calculation
    } catch (error) {
        // Menampilkan pesan kesalahan jika terjadi error
        document.getElementById('result').innerText = 'Error';
        expression = '';
        displayExpression = '';
        resultDisplayed = false; // Set ulang status hasil ditampilkan
        enableEqualsButton(); // Enable equals button on error
    }
}

// Fungsi untuk memperbarui tampilan ekspresi saat ini
function updateDisplay() {
    document.getElementById('result').innerText = expression || '0'; // Tampilkan hasil
}

// Fungsi untuk menonaktifkan tombol "="
function disableEqualsButton() {
    document.getElementById('equals-button').disabled = true; // Ganti dengan ID tombol =
}

// Fungsi untuk mengaktifkan tombol "="
function enableEqualsButton() {
    document.getElementById('equals-button').disabled = false; // Ganti dengan ID tombol =
}
