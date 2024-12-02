// Fungsi untuk menangani form submit dan mengirim data ke API
document.getElementById('add-product-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah form dari reload halaman

    const formData = new FormData();
    formData.append('product_name', document.getElementById('product-name').value);
    formData.append('price', document.getElementById('product-price').value);
    formData.append('image', document.getElementById('product-image').files[0]);

    // Kirim data ke API menggunakan fetch
    fetch('http://localhost:8000/api/product', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        const message = document.getElementById('response-message');
        
        if (data.status === 200) { // Periksa status sukses
            message.innerHTML = '<p>Produk berhasil ditambahkan!</p>';
            message.style.color = 'green';
            document.getElementById('add-product-form').reset(); // Reset form setelah berhasil
        } else {
            message.innerHTML = `<p>Gagal menambahkan produk: ${data.message}</p>`;
            message.style.color = 'red';
        }
    })
    .catch(error => {
        const message = document.getElementById('response-message');
        message.innerHTML = '<p>Terjadi kesalahan, silakan coba lagi.</p>';
        message.style.color = 'red';
        console.error('Error:', error);
    });
});
