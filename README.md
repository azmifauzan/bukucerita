# 📚 BukuCerita

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/Vue.js-3.x-green.svg" alt="Vue.js Version">
  <img src="https://img.shields.io/badge/Inertia.js-2.x-purple.svg" alt="Inertia.js Version">
  <img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License">
</p>

**BukuCerita** adalah aplikasi web modern untuk mengelola dan berbagi koleksi buku cerita. Dibangun dengan Laravel 12, Vue.js 3, dan Inertia.js untuk memberikan pengalaman pengguna yang seamless dan interaktif.

## ✨ Fitur Utama

- 📖 **Manajemen Buku**: Tambah, edit, dan kelola koleksi buku cerita
- 🏷️ **Kategori Buku**: Organisasi buku berdasarkan kategori
- 👥 **Sistem Pengguna**: Registrasi, login, dan profil pengguna
- 🔒 **Autentikasi**: Sistem keamanan dengan Laravel Sanctum & Jetstream
- 📊 **Dashboard Admin**: Panel administrasi untuk mengelola konten
- 🎯 **Filter Usia**: Sistem rekomendasi berdasarkan usia pembaca
- 📈 **Tracking Views**: Pelacakan popularitas buku
- 🔗 **Link Eksternal**: Dukungan untuk YouTube dan link eksternal
- 📱 **Responsive Design**: Tampilan yang optimal di semua perangkat
- 🚀 **SEO Optimized**: Sitemap dan robots.txt untuk SEO

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 12** - Framework PHP modern
- **PHP 8.2+** - Bahasa pemrograman server
- **SQLite** - Database (dapat diganti dengan MySQL/PostgreSQL)
- **Laravel Sanctum** - Autentikasi API
- **Laravel Jetstream** - Scaffolding autentikasi & profil

### Frontend
- **Vue.js 3** - Framework JavaScript reaktif
- **Inertia.js 2** - Modern monolith untuk SPA-like experience
- **Tailwind CSS** - Framework CSS utility-first
- **Vite** - Build tool yang cepat

### Testing & Development
- **Pest PHP 4** - Framework testing modern
- **Laravel Pint** - Code formatter
- **Laravel Sail** - Docker environment
- **Laravel Boost** - Development tools

## 🚀 Instalasi & Setup

### Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & npm
- SQLite (atau database lain)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/azmifauzan/bukucerita.git
   cd bukucerita
   ```

2. **Install Dependencies**
   ```bash
   # Install PHP dependencies
   composer install
   
   # Install JavaScript dependencies
   npm install
   ```

3. **Environment Setup**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   # Run migrations
   php artisan migrate
   
   # Seed database (optional)
   php artisan db:seed
   ```

5. **Build Assets**
   ```bash
   # Development
   npm run dev
   
   # Production
   npm run build
   ```

6. **Start Development Server**
   ```bash
   php artisan serve
   ```

### Menggunakan Docker (Laravel Sail)

```bash
# Start services
./vendor/bin/sail up -d

# Run migrations
./vendor/bin/sail artisan migrate

# Build assets
./vendor/bin/sail npm run dev
```

## 📁 Struktur Project

```
bukucerita/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── ...
├── database/
│   ├── factories/           # Model Factories
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Database Seeders
├── resources/
│   ├── js/                 # Vue.js Components & Pages
│   ├── css/                # Stylesheets
│   └── views/              # Blade Templates
├── routes/
│   ├── web.php             # Web Routes
│   └── api.php             # API Routes
├── tests/                  # Pest Tests
└── docker/                 # Docker Configuration
```

## 🎯 Penggunaan

### Untuk Pengguna
1. Daftar akun baru atau login
2. Jelajahi koleksi buku cerita
3. Filter buku berdasarkan kategori atau usia
4. Tambahkan buku baru ke koleksi
5. Kelola profil dan preferensi

### Untuk Admin
1. Akses dashboard admin
2. Kelola semua buku dan kategori
3. Moderasi konten yang dikirim pengguna
4. Analisis statistik penggunaan

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run tests with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/BookTest.php

# Run tests with filter
php artisan test --filter=book
```

## 🔧 Development Tools

```bash
# Format code
./vendor/bin/pint

# Run development server with hot reload
npm run dev

# Check for code issues
php artisan insights
```

## 🐳 Docker Support

Aplikasi ini sudah dikonfigurasi untuk berjalan dengan Docker menggunakan Laravel Sail:

```bash
# Start all services
./vendor/bin/sail up -d

# Stop services
./vendor/bin/sail down

# Access container shell
./vendor/bin/sail shell
```

## 📊 Monitoring & Logging

- **Logs**: Tersedia di `storage/logs/`
- **Performance**: Monitoring performa aplikasi
- **Error Tracking**: Log error otomatis

## 🤝 Contributing

Kami menyambut kontribusi dari komunitas! Silakan:

1. Fork repository ini
2. Buat branch untuk fitur baru (`git checkout -b feature/amazing-feature`)
3. Commit perubahan (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buat Pull Request

## 📄 License

Aplikasi ini berlisensi [MIT License](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

Dibuat dengan ❤️ oleh [Azmi Fauzan](https://github.com/azmifauzan)

## 📞 Support

Jika Anda menemukan bug atau memiliki saran, silakan buat [issue baru](https://github.com/azmifauzan/bukucerita/issues).

---

**BukuCerita** - Membuat membaca menjadi lebih menyenangkan! 📚✨
