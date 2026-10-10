const toggleBtn = document.getElementById('toggle-btn');
const mainWrapper = document.getElementById('main-wrapper');

toggleBtn.addEventListener('click', () => {
  // Ini pancingannya: 'toggling' class di elemen paling luar
  mainWrapper.classList.toggle('toggled');
  
  
});
const menuItems = document.querySelectorAll('.list-group-item');

menuItems.forEach(item => {
    item.addEventListener('click', function() {
        // 1. Hapus class 'active' dari semua menu
        menuItems.forEach(i => i.classList.remove('active'));
        
        // 2. Tambahkan class 'active' hanya ke menu yang baru saja diklik
        this.classList.add('active');
    });
});