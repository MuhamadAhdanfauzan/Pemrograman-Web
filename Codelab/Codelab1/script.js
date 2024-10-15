function validateForm() {
    // Mengambil nilai dari form input
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    
    // Mengambil elemen error
    var nameError = document.getElementById("nameError");
    var emailError = document.getElementById("emailError");
    var passwordError = document.getElementById("passwordError");

    // Reset tampilan error
    document.getElementById("name").classList.remove("error");
    document.getElementById("email").classList.remove("error");
    document.getElementById("password").classList.remove("error");
    nameError.style.display = "none";
    emailError.style.display = "none";
    passwordError.style.display = "none";

    var isValid = true;

    // Validasi Nama
    if (name === "") {
        document.getElementById("name").classList.add("error");
        nameError.style.display = "block";
        isValid = false;
    }

    // Validasi Email
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        document.getElementById("email").classList.add("error");
        emailError.style.display = "block";
        isValid = false;
    }

    // Validasi Kata Sandi
    if (password.length < 6) {
        document.getElementById("password").classList.add("error");
        passwordError.style.display = "block";
        isValid = false;
    }

    if (isValid) {
        alert("Pendaftaran berhasil!");
    }
}
