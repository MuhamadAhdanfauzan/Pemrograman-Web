function hitungJumlah() {
    var angka1 = parseFloat(document.getElementById("angka1").value);
    var angka2 = parseFloat(document.getElementById("angka2").value);
    var hasil = angka1 + angka2;
    document.getElementById("hasil").innerText = hasil;
}
