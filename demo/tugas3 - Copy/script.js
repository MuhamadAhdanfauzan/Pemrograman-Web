// Fungsi untuk memuat produk dari API
function loadProducts() {
  // Ganti URL dengan endpoint API yang benar
  fetch('http://localhost:8000/api/product')
    .then(response => response.json())
    .then(data => {
      const productList = document.getElementById('product-list');
      productList.innerHTML = ''; // Clear the existing product list

      // Periksa apakah data yang diterima ada
      if (data && data.data) {
        // Loop untuk menampilkan produk
        data.data.forEach(product => {
          const productCard = document.createElement('div');
          productCard.classList.add('product-card');

          productCard.innerHTML = `
            <img src="${product.image_url}" alt="${product.product_name}">
            <h3>${product.product_name}</h3>
            <p class="price">Rp ${product.price}</p>
          `;

          productList.appendChild(productCard);
        });
      } else {
        productList.innerHTML = '<p>No products available.</p>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

// Panggil fungsi loadProducts() saat halaman dimuat
document.addEventListener('DOMContentLoaded', loadProducts);
