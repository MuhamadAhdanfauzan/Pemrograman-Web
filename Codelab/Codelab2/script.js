document.getElementById('pendaftaranForm').addEventListener('submit', function(event) {
    var nama = document.getElementById('nama').value;
    var email = document.getElementById('email').value;
    var alamat = document.getElementById('alamat').value;

    if (nama === "" || email === "" || alamat === "") {
        event.preventDefault();
        alert("Semua data harus diisi.");
    }
});
