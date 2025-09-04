<template>
  <div class="home-page">
    <section class="hero-section">
      <div class="hero-content">
        <div class="hero-text">
          <h1>🌟 Selamat Datang di Dunia Cerita! 🌟</h1>
          <p class="hero-description">Jelajahi dunia penuh petualangan dan keajaiban melalui cerita-cerita menarik yang mengajarkan nilai-nilai kehidupan!</p>
          <router-link to="/collection" class="cta-button">
            🚀 Mulai Petualangan
          </router-link>
        </div>
        <div class="hero-image">
          <div class="floating-books">
            <div class="book book-1">📚</div>
            <div class="book book-2">📖</div>
            <div class="book book-3">📕</div>
            <div class="book book-4">📗</div>
          </div>
        </div>
      </div>
    </section>

    <section class="popular-section">
      <div class="section-header">
        <h2>✨ Cerita Paling Disukai ✨</h2>
        <p>Cerita favorit yang telah dibaca ribuan anak</p>
      </div>
      
      <div class="loading" v-if="loading">
        <div class="spinner">🔄</div>
        <p>Sedang memuat cerita...</p>
      </div>
      
      <div class="book-carousel" v-else>
        <div class="book-card" v-for="book in displayBooks" :key="book.id">
          <router-link :to="'/book/' + book.id" @click="incrementReadCount(book.id)">
            <div class="book-cover">
              <img :src="book.coverImage || book.cover_image" :alt="book.title" @error="handleImageError">
              <div class="read-count">
                👀 {{ formatReadCount(book.readCount || book.read_count) }}
              </div>
            </div>
            <div class="book-info">
              <h3>{{ book.title }}</h3>
              <p class="author">📝 {{ book.author }}</p>
              <p class="synopsis">{{ truncateSynopsis(book.synopsis) }}</p>
            </div>
          </router-link>
        </div>
      </div>
      
      <div class="view-all">
        <router-link to="/collection" class="view-all-btn">
          📚 Lihat Semua Cerita
        </router-link>
      </div>
    </section>

    <section class="features-section">
      <div class="section-header">
        <h2>🎯 Mengapa Memilih BukuCerita?</h2>
      </div>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">🎨</div>
          <h3>Desain Menarik</h3>
          <p>Tampilan colorful dan ramah anak untuk pengalaman membaca yang menyenangkan</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">📱</div>
          <h3>Mobile Friendly</h3>
          <p>Dapat diakses dengan mudah di smartphone, tablet, atau komputer</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">🧠</div>
          <h3>Edukatif</h3>
          <p>Setiap cerita mengandung nilai moral dan pembelajaran untuk perkembangan karakter</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">🆓</div>
          <h3>Gratis</h3>
          <p>Akses unlimited ke semua cerita tanpa biaya berlangganan</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { bookService } from '@/utils/supabase'

export default {
  name: 'HomePage',
  data() {
    return {
      books: [],
      loading: true,
    };
  },
  computed: {
    displayBooks() {
      // Show top 6 most popular books
      return this.books.slice(0, 6);
    }
  },
  methods: {
    async fetchBooks() {
      this.loading = true;
      try {
        this.books = await bookService.getApprovedBooks();
      } catch (error) {
        console.error('Error fetching books:', error);
        // Fallback to static data if needed
        const { default: staticBooks } = await import('@/data/books.json');
        this.books = staticBooks.filter(book => book.status === 'approved');
      } finally {
        this.loading = false;
      }
    },
    formatReadCount(count) {
      if (!count) return '0';
      if (count >= 1000) {
        return `${(count / 1000).toFixed(1)}k`;
      }
      return count.toString();
    },
    truncateSynopsis(synopsis) {
      if (!synopsis) return '';
      return synopsis.length > 80 ? synopsis.substring(0, 80) + '...' : synopsis;
    },
    handleImageError(event) {
      // Fallback image or placeholder
      event.target.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjI1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjNmNGY2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSI0MCIgZmlsbD0iIzljYTNhZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPvCfk5o8L3RleHQ+PC9zdmc+';
    },
    async incrementReadCount(bookId) {
      try {
        await bookService.incrementReadCount(bookId);
      } catch (error) {
        console.error('Error incrementing read count:', error);
      }
    }
  },
  async mounted() {
    await this.fetchBooks();
  }
};
</script>

<style scoped>
.home-page {
  width: 100%;
  overflow-x: hidden;
}

/* Hero Section */
.hero-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 4rem 2rem;
  border-radius: 0 0 50px 50px;
  margin: -2rem -1rem 3rem;
  position: relative;
  overflow: hidden;
}

.hero-content {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  align-items: center;
}

.hero-text h1 {
  font-size: 3rem;
  margin-bottom: 1.5rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
  line-height: 1.2;
}

.hero-description {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  opacity: 0.95;
  line-height: 1.6;
}

.cta-button {
  display: inline-block;
  background: linear-gradient(135deg, #ff6b6b, #ee5a24);
  color: white;
  padding: 1rem 2rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: bold;
  font-size: 1.1rem;
  box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
  transition: all 0.3s ease;
}

.cta-button:hover {
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 10px 30px rgba(255, 107, 107, 0.5);
}

/* Floating Books Animation */
.hero-image {
  position: relative;
  height: 300px;
}

.floating-books {
  position: relative;
  width: 100%;
  height: 100%;
}

.book {
  position: absolute;
  font-size: 3rem;
  animation: float 6s ease-in-out infinite;
  filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
}

.book-1 {
  top: 10%;
  left: 20%;
  animation-delay: 0s;
}

.book-2 {
  top: 60%;
  left: 10%;
  animation-delay: 1.5s;
}

.book-3 {
  top: 20%;
  right: 10%;
  animation-delay: 3s;
}

.book-4 {
  bottom: 20%;
  right: 30%;
  animation-delay: 4.5s;
}

@keyframes float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(5deg); }
}

/* Popular Section */
.popular-section {
  margin: 4rem 0;
}

.section-header {
  text-align: center;
  margin-bottom: 3rem;
}

.section-header h2 {
  font-size: 2.5rem;
  color: #4f46e5;
  margin-bottom: 1rem;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}

.section-header p {
  font-size: 1.1rem;
  color: #6b7280;
  max-width: 600px;
  margin: 0 auto;
}

/* Loading */
.loading {
  text-align: center;
  padding: 3rem;
  color: #6b7280;
}

.spinner {
  font-size: 3rem;
  animation: spin 2s linear infinite;
  margin-bottom: 1rem;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Book Carousel */
.book-carousel {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
  margin-bottom: 3rem;
}

.book-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.book-card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.book-card a {
  text-decoration: none;
  color: inherit;
  display: block;
}

.book-cover {
  position: relative;
  height: 300px;
  overflow: hidden;
}

.book-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.book-card:hover .book-cover img {
  transform: scale(1.05);
}

.read-count {
  position: absolute;
  top: 15px;
  right: 15px;
  background: rgba(0, 0, 0, 0.7);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.9rem;
  backdrop-filter: blur(5px);
}

.book-info {
  padding: 1.5rem;
}

.book-info h3 {
  font-size: 1.3rem;
  color: #1f2937;
  margin-bottom: 0.5rem;
  line-height: 1.4;
}

.author {
  color: #10b981;
  font-weight: 600;
  margin-bottom: 1rem;
}

.synopsis {
  color: #6b7280;
  line-height: 1.6;
  font-size: 0.95rem;
}

/* View All Button */
.view-all {
  text-align: center;
}

.view-all-btn {
  display: inline-block;
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  padding: 1rem 2.5rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: bold;
  font-size: 1.1rem;
  box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
  transition: all 0.3s ease;
}

.view-all-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
}

/* Features Section */
.features-section {
  background: linear-gradient(135deg, #fef7ff, #f3e8ff);
  padding: 4rem 2rem;
  border-radius: 30px;
  margin: 4rem -1rem 0;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  max-width: 1000px;
  margin: 0 auto;
}

.feature-card {
  background: white;
  padding: 2rem;
  border-radius: 20px;
  text-align: center;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
}

.feature-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

.feature-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.feature-card h3 {
  font-size: 1.4rem;
  color: #1f2937;
  margin-bottom: 1rem;
}

.feature-card p {
  color: #6b7280;
  line-height: 1.6;
}

/* Mobile Styles */
@media (max-width: 768px) {
  .hero-section {
    padding: 3rem 1rem;
    margin: -1rem -0.5rem 2rem;
    border-radius: 0 0 30px 30px;
  }
  
  .hero-content {
    grid-template-columns: 1fr;
    gap: 2rem;
    text-align: center;
  }
  
  .hero-text h1 {
    font-size: 2.2rem;
  }
  
  .hero-description {
    font-size: 1.1rem;
  }
  
  .hero-image {
    height: 200px;
  }
  
  .book {
    font-size: 2.5rem;
  }
  
  .section-header h2 {
    font-size: 2rem;
  }
  
  .book-carousel {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
  }
  
  .book-cover {
    height: 250px;
  }
  
  .features-section {
    padding: 3rem 1rem;
    margin: 3rem -0.5rem 0;
    border-radius: 20px;
  }
  
  .features-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  .feature-card {
    padding: 1.5rem;
  }
}

/* Extra Small Mobile */
@media (max-width: 480px) {
  .hero-text h1 {
    font-size: 1.8rem;
  }
  
  .hero-description {
    font-size: 1rem;
  }
  
  .cta-button {
    padding: 0.8rem 1.5rem;
    font-size: 1rem;
  }
  
  .book-carousel {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  
  .book-cover {
    height: 220px;
  }
  
  .book-info {
    padding: 1rem;
  }
}
</style>
