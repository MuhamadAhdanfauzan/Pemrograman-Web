// Fungsi untuk memuat produk dari API
function loadProducts() {
  // URL API Anda
  fetch('http://localhost:8000/api/product')
    .then(response => response.json()) // Menangani respons JSON
    .then(data => {
      const productList = document.getElementById('product-list');
      productList.innerHTML = ''; // Mengosongkan daftar produk yang ada

      // Periksa apakah data yang diterima valid
      if (data && data.data && Array.isArray(data.data)) {
        // Loop untuk menampilkan produk
        data.data.forEach(product => {
          const productCard = document.createElement('div');
          productCard.classList.add('country__card');

          // Menggunakan URL gambar langsung dari database
          const imageUrl = product.image_url; 

          // Konten kartu produk
          productCard.innerHTML = `
            <img src="${imageUrl}" alt="${product.product_name}" class="product-image" />
            <div class="country__name">
              <span>${product.product_name}</span>
            </div>
            <p class="price">Rp ${product.price.toLocaleString('id-ID')}</p>
          `;

          // Menambahkan kartu ke daftar produk
          productList.appendChild(productCard);
        });
      } else {
        // Tampilkan pesan jika tidak ada produk
        productList.innerHTML = '<p>No products available.</p>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      const productList = document.getElementById('product-list');
      productList.innerHTML = '<p>Terjadi kesalahan saat memuat produk.</p>';
    });
}

// Panggil fungsi loadProducts() saat halaman dimuat
document.addEventListener('DOMContentLoaded', loadProducts);
