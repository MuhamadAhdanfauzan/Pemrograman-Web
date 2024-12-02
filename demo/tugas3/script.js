const apiUrl = 'http://localhost:8000/api/product';

// Load products on page load
document.addEventListener('DOMContentLoaded', loadProducts);

// Form submission handler
document.getElementById('product-form').addEventListener('submit', (e) => {
  e.preventDefault();

  const id = document.getElementById('product-id').value;
  const name = document.getElementById('product-name').value;
  const image = document.getElementById('product-image').value;
  const price = document.getElementById('product-price').value;

  if (id) {
    updateProduct(id, name, image, price);
  } else {
    createProduct(name, image, price);
  }

  clearForm();
});

// Load products
function loadProducts() {
  fetch(apiUrl)
    .then((res) => res.json())
    .then((data) => {
      const tableBody = document.getElementById('product-table').querySelector('tbody');
      tableBody.innerHTML = '';

      data.data.forEach((product) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${product.product_name}</td>
          <td><img src="uploads/${product.image}" alt="${product.product_name}" style="width: 50px;" /></td>
          <td>Rp ${product.price}</td>
          <td>
            <button onclick="editProduct(${product.id}, '${product.product_name}', '${product.image}', ${product.price})">Edit</button>
            <button onclick="deleteProduct(${product.id})">Delete</button>
          </td>
        `;
        tableBody.appendChild(row);
      });
    })
    .catch((error) => console.error('Error:', error));
}

// Create product
function createProduct(name, image, price) {
  fetch(apiUrl, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ product_name: name, image, price }),
  })
    .then((res) => res.json())
    .then(() => loadProducts())
    .catch((error) => console.error('Error:', error));
}

// Edit product
function editProduct(id, name, image, price) {
  document.getElementById('product-id').value = id;
  document.getElementById('product-name').value = name;
  document.getElementById('product-image').value = image;
  document.getElementById('product-price').value = price;
  document.getElementById('save-button').textContent = 'Update Product';
}

// Update product
function updateProduct(id, name, image, price) {
  fetch(`${apiUrl}/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ product_name: name, image, price }),
  })
    .then((res) => res.json())
    .then(() => {
      loadProducts();
      document.getElementById('save-button').textContent = 'Add Product';
    })
    .catch((error) => console.error('Error:', error));
}

// Delete product
function deleteProduct(id) {
  fetch(`${apiUrl}/${id}`, { method: 'DELETE' })
    .then((res) => res.json())
    .then(() => loadProducts())
    .catch((error) => console.error('Error:', error));
}

// Clear form inputs
function clearForm() {
  document.getElementById('product-id').value = '';
  document.getElementById('product-name').value = '';
  document.getElementById('product-image').value = '';
  document.getElementById('product-price').value = '';
}
