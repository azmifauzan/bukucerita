# 📚 BukuCerita - Platform Cerita Anak Digital

Selamat datang di BukuCerita! Platform digital yang menyediakan koleksi cerita anak-anak yang edukatif dan menarik dengan tampilan yang ramah anak dan mobile-first.

## ✨ Fitur Utama

- 🎨 **Desain Modern & Child-Friendly**: Tampilan colorful dan menarik untuk anak-anak
- 📱 **Mobile-First Responsive**: Optimized untuk semua ukuran layar
- 🔄 **Integrasi Supabase**: Real-time database untuk manajemen konten
- 🚀 **Performance Optimized**: Fast loading dengan lazy loading images
- 🎯 **User Experience**: Navigation yang intuitif dan mudah digunakan
- ❤️ **Favorite System**: Sistem bookmark untuk cerita favorit

## 🛠️ Teknologi yang Digunakan

- **Vue.js 3** - Progressive JavaScript Framework
- **Vue Router 4** - Official router for Vue.js
- **Supabase** - Backend as a Service untuk database dan API
- **Modern CSS** - Gradient, backdrop-filter, dan animasi
- **Mobile-First Design** - Responsive untuk semua device

## 🚀 Quick Start

### Prerequisites
- Node.js 14 atau lebih tinggi
- npm atau yarn

1. **Clone repository**
```bash
git clone https://github.com/azmifauzan/bukucerita.git
cd bukucerita
```

2. **Install dependencies**
```bash
npm install
# atau
yarn install
```

3. **Setup Environment Variables**

### Backend (optional - secure operations)

There is a small Express backend in the `server/` folder which is optional but recommended for admin operations that require the Supabase service_role key.

To run the server locally:

- cd server
- npm install
- copy `.env.example` to `.env` and fill values (do NOT commit real keys)
- npm run dev

The server exposes endpoints:
- GET /books
- GET /books/:id
- POST /books (public submissions -> saved as status='pending')
- POST /books/:id/increment
- PUT /admin/books/:id (admin update)
- DELETE /admin/books/:id (admin delete)

DDL for Supabase `books` table (run in SQL editor):

-- Books table
CREATE TABLE public.books (
	id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),
	title text NOT NULL,
	author text,
	synopsis text,
	cover_image text,
	gemini_storybook_url text,
	status text DEFAULT 'pending', -- 'pending' | 'approved' | 'rejected'
	read_count integer DEFAULT 0,
	created_at timestamptz DEFAULT now(),
	updated_at timestamptz DEFAULT now()
);

-- function to increment read_count (optional)
create or replace function public.increment_read_count(book_id uuid)
returns void language plpgsql as $$
begin
	update public.books set read_count = coalesce(read_count,0) + 1, updated_at = now() where id = book_id;
end;
$$;
```bash
# Copy file environment example
cp .env.example .env

```

4. **Jalankan Development Server**

5. **Buka di browser**
```
http://localhost:8080
```
## 📱 Mobile-First Approach

Design dimulai dari mobile kemudian scaled up:
- **Mobile**: < 480px (Single column, full width)
- **Tablet**: 481px - 768px (Grid 2 columns)  
- **Desktop**: > 768px (Grid 3+ columns)

## 🎨 Design Features

- **Gradients**: Animated background gradients
- **Cards**: Modern card design dengan hover effects
- **Typography**: Child-friendly fonts (Comic Sans MS)
- **Colors**: Bright, engaging color palette
- **Animations**: Smooth transitions dan micro-interactions

## 📞 Support

Jika ada pertanyaan atau issue, silakan buat issue di GitHub repository.

---

**Dibuat dengan ❤️ untuk anak-anak Indonesia**
