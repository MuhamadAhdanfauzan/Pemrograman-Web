// Menambahkan event listener pada tombol Add
document.getElementById('add-btn').addEventListener('click', function() {
    const taskText = document.getElementById('new-task').value.trim(); // Menghilangkan spasi kosong di awal/akhir input

    // Validasi: Pastikan input tidak kosong
    if (taskText === '') {
        alert('Please enter a task!');
        return;
    }

    const todoList = document.getElementById('todo-list');
    const li = document.createElement('li');

    // Membuat checkbox untuk menandai tugas selesai
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';

    // Membuat label untuk menampilkan teks tugas
    const label = document.createElement('label');
    label.textContent = taskText;
    label.classList.add('task-label');

    // Membuat input untuk mengedit tugas
    const editInput = document.createElement('input');
    editInput.type = 'text';
    editInput.value = taskText; // Menetapkan nilai awal untuk input edit
    editInput.classList.add('edit-input');

    // Membuat tombol edit tugas
    const editBtn = document.createElement('button');
    editBtn.textContent = '✎'; // Simbol untuk edit
    editBtn.classList.add('edit-btn');

    // Membuat tombol hapus tugas
    const deleteBtn = document.createElement('button');
    deleteBtn.textContent = '✕';
    deleteBtn.classList.add('delete-btn');

    // Menyusun elemen ke dalam li
    li.appendChild(checkbox);
    li.appendChild(label);
    li.appendChild(editInput);
    li.appendChild(editBtn);
    li.appendChild(deleteBtn);
    todoList.appendChild(li);

    // Reset input setelah menambahkan tugas
    document.getElementById('new-task').value = '';

    // Event listener untuk tombol delete (hapus tugas)
    deleteBtn.addEventListener('click', function() {
        todoList.removeChild(li); // Menghapus li dari ul
    });

    // Fungsi untuk menyimpan perubahan saat editing
    function saveEdit() {
        label.style.display = 'inline'; // Tampilkan label kembali
        editInput.style.display = 'none'; // Sembunyikan input edit
        label.textContent = editInput.value; // Perbarui teks label
    }

    // Event listener untuk tombol edit (mengedit tugas)
    editBtn.addEventListener('click', function() {
        if (editInput.style.display === 'none') {
            editInput.style.display = 'inline'; // Tampilkan input edit
            label.style.display = 'none'; // Sembunyikan label
            editInput.focus(); // Fokus pada input edit
        } else {
            saveEdit(); // Simpan perubahan
        }
    });

    // Menangani Enter key untuk menyimpan edit
    editInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            saveEdit(); // Simpan perubahan saat Enter ditekan
        }
    });

    // Event listener untuk checkbox (tugas selesai)
    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            label.style.textDecoration = 'line-through'; // Memberi efek coret pada teks
        } else {
            label.style.textDecoration = 'none'; // Menghilangkan efek coret jika tidak dicentang
        }
    });
});

// Event listener untuk checkbox "Select All"
document.getElementById('select-all').addEventListener('change', function() {
    const checked = this.checked; // Ambil status checkbox "Select All"
    const checkboxes = document.querySelectorAll('#todo-list input[type="checkbox"]');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = checked; // Set status setiap checkbox sesuai dengan "Select All"
    });
});

// Event listener untuk tombol "Delete Selected"
document.getElementById('delete-selected-btn').addEventListener('click', function() {
    const todoList = document.getElementById('todo-list');
    const checkboxes = todoList.querySelectorAll('input[type="checkbox"]:checked'); // Pilih checkbox yang dicentang

    checkboxes.forEach(checkbox => {
        const li = checkbox.parentElement; // Ambil elemen li dari checkbox
        todoList.removeChild(li); // Hapus li dari daftar todo
    });

    // Uncheck checkbox "Select All" setelah menghapus
    document.getElementById('select-all').checked = false;
});
