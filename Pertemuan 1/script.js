document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('productForm');
    const subKategori = document.getElementById('subKategori');
    const kategori = document.getElementById('kategori');
    const hargaGrosir = document.getElementById('hargaGrosir');
    const grosirYa = document.getElementById('grosirYa');
    const grosirTidak = document.getElementById('grosirTidak');
    const captchaCode = document.getElementById('captchaCode');
    const subCategories = {
        'Baju': ['Baju Pria', 'Baju Wanita', 'Baju Anak'],
        'Elektronik': ['Mesin Cuci', 'Kulkas', 'AC'],
        'Alat Tulis': ['Kertas', 'Map', 'Pulpen']
    };

    kategori.addEventListener('change', function() {
        const selectedCategory = this.value;
        subKategori.innerHTML = '<option value="">--Pilih Sub Kategori--</option>';
        if (subCategories[selectedCategory]) {
            subCategories[selectedCategory].forEach(function(sub) {
                const option = document.createElement('option');
                option.value = sub;
                option.text = sub;
                subKategori.add(option);
            });
        }
    });

    grosirYa.addEventListener('change', function() {
        hargaGrosir.required = true;
        hargaGrosir.disabled = false;
    });

    grosirTidak.addEventListener('change', function() {
        hargaGrosir.required = false;
        hargaGrosir.value = '';
        hargaGrosir.disabled = true;
    });

    function generateCaptcha() {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        let captcha = "";
        for (let i = 0; i < 5; i++) {
            captcha += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        captchaCode.value = captcha;
    }
    
    generateCaptcha();

    form.addEventListener('submit', function(e) {
        const selectedShipping = document.querySelectorAll('input[name="jasaKirim"]:checked');
        if (selectedShipping.length < 3) {
            alert('Pilih minimal 3 jasa kirim.');
            e.preventDefault();
            return;
        }

        const namaProduk = document.getElementById('namaProduk').value;
        if (namaProduk.length < 5 || namaProduk.length > 30) {
            alert('Nama produk harus diisi minimal 5 karakter dan maksimal 30 karakter.');
            e.preventDefault();
            return;
        }

        const deskripsi = document.getElementById('deskripsi').value;
        if (deskripsi.length < 5 || deskripsi.length > 100) {
            alert('Deskripsi harus diisi minimal 5 karakter dan maksimal 100 karakter.');
            e.preventDefault();
            return;
        }

        const captchaInput = document.getElementById('captcha').value;
        if (captchaInput !== captchaCode.value) {
            alert('Captcha tidak sesuai.');
            e.preventDefault();
            return;
        }
    });
});