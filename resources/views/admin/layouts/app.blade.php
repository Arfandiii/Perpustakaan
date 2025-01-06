<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Online SMA 1 Siantan | {{ $title ?? 'Peronsmansasi' }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body x-data="{ isOpen: false }">

    <!-- Navbar -->
    @include('admin.layouts.header')

    <!-- Sidebar -->
    @include('admin.layouts.sidebar')

    <!-- Content -->
    <div class="container mx-auto">
        @yield('content')
        <!-- Konten spesifik halaman -->
    </div>

    <!-- Footer -->
    @include('layouts.footer')


    <script>
        function displayPreview(event) {
            const file = event.target.files[0]; // Ambil file yang dipilih
            if (!file) return; // Jika tidak ada file, hentikan proses
            
            // Validasi ukuran file (10MB maksimal)
            if (file.size > 10 * 1024 * 1024) {
                alert("Ukuran file terlalu besar! Maksimum 10MB.");
                event.target.value = ""; // Reset input file
                return;
            }
            
            // Validasi tipe file
            const validTypes = ["image/png", "image/jpeg", "image/gif"];
            if (!validTypes.includes(file.type)) {
                alert("Format file tidak didukung! Hanya PNG, JPG, atau GIF yang diizinkan.");
                event.target.value = ""; // Reset input file
                return;
            }
    
            // Tampilkan preview gambar
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                const label = document.getElementById('upload-label');
                preview.src = e.target.result; // Set sumber gambar ke hasil baca file
                preview.classList.remove('hidden'); // Tampilkan preview
                label.classList.add('hidden'); // Sembunyikan label
            };
            reader.readAsDataURL(file);
        }
    </script>
    <script>
        const sidebar = document.querySelector("aside");
            const maxSidebar = document.querySelector(".max");
            const miniSidebar = document.querySelector(".mini");
            const roundout = document.querySelector(".roundout");
            const maxToolbar = document.querySelector(".max-toolbar");
            const logo = document.querySelector('.logo');
            const content = document.querySelector('.content');
            const footer = document.querySelector('.footer');
    
            function openNav() {
                if(sidebar.classList.contains('-translate-x-48')){
                    // max sidebar 
                    sidebar.classList.remove("-translate-x-48")
                    sidebar.classList.add("translate-x-none")
                    maxSidebar.classList.remove("hidden")
                    maxSidebar.classList.add("flex")
                    miniSidebar.classList.remove("flex")
                    miniSidebar.classList.add("hidden")
                    maxToolbar.classList.add("translate-x-0")
                    maxToolbar.classList.remove("translate-x-24","scale-x-0")
                    logo.classList.remove("ml-12")
                    content.classList.remove("ml-12")
                    content.classList.add("ml-12","md:ml-60")
                    footer.classList.remove("mx-2")
                    footer.classList.add("mx-2","md:ml-52")
                    content.classList.add("ml-12","md:ml-60")
                }else{
                    // mini sidebar
                    sidebar.classList.add("-translate-x-48")
                    sidebar.classList.remove("translate-x-none")
                    maxSidebar.classList.add("hidden")
                    maxSidebar.classList.remove("flex")
                    miniSidebar.classList.add("flex")
                    miniSidebar.classList.remove("hidden")
                    maxToolbar.classList.add("translate-x-24","scale-x-0")
                    maxToolbar.classList.remove("translate-x-0")
                    logo.classList.add('ml-12')
                    content.classList.remove("ml-12","md:ml-60")
                    content.classList.add("ml-12")
                    footer.classList.remove("mx-2","md:ml-52")
                    footer.classList.add("mx-2")
                }
    
            }
    </script>
    <script>
        const updateDateTime = () => {
        const dateTimeElement = document.getElementById('current-date-time');
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const now = new Date();
        
        const date = now.toLocaleDateString('id-ID', options); // Format tanggal
        const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }); // Format waktu
        
        dateTimeElement.textContent = `${date}, ${time}`; // Gabungkan tanggal dan waktu
    };
    
    updateDateTime(); // Set tanggal dan waktu pertama kali
    setInterval(updateDateTime, 1000); // Perbarui setiap detik
    </script>
    {{-- <script>
        // Peminjaman Buku (Bar Chart)
        const borrowCtx = document.getElementById('borrowChart').getContext('2d');
        new Chart(borrowCtx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: [12, 19, 7, 10, 15, 9, 13], // Data dummy
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    
        // Kategori Buku Populer (Pie Chart)
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: ['Fiksi', 'Non-Fiksi', 'Sains', 'Sejarah', 'Teknologi'],
                datasets: [{
                    label: 'Kategori Populer',
                    data: [25, 15, 20, 10, 30], // Data dummy
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    
        // Aktivitas Pengguna (Line Chart)
        const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
        new Chart(userActivityCtx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Jumlah Login',
                    data: [5, 10, 8, 6, 12, 7, 10], // Data dummy
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4 // Membuat garis lebih halus
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script> --}}
    {{-- <script>
        const borrowData = @json($borrowData);
        const categoryData = @json($categoryData);
        const userActivity = @json($userActivity);
    
        // Replace `data` in Chart.js with `borrowData`, `categoryData`, etc.
    </script> --}}
</body>

</html>