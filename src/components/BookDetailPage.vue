<template>
  <div class="book-detail-page">
    <div class="loading" v-if="loading">
      <div class="spinner">🔄</div>
      <p>Memuat detail buku...</p>
    </div>

    <div v-else-if="book" class="book-content">
      <!-- Back Button -->
      <button @click="goBack" class="back-btn">
        ⬅️ Kembali
      </button>

      <!-- Book Header -->
      <div class="book-header">
        <div class="cover-container">
          <img :src="book.coverImage || book.cover_image" :alt="book.title" class="cover-image" @error="handleImageError">
          <div class="cover-overlay">
            <div class="status-badge" :class="book.status">
              {{ getStatusEmoji(book.status) }} {{ getStatusText(book.status) }}
            </div>
          </div>
        </div>
        
        <div class="book-info">
          <h1 class="book-title">{{ book.title }}</h1>
          <p class="book-author">📝 Ditulis oleh <strong>{{ book.author }}</strong></p>
          
          <div class="book-stats">
            <div class="stat-item">
              <span class="stat-icon">👀</span>
              <span class="stat-text">{{ formatReadCount(displayReadCount) }} pembaca</span>
            </div>
            <div class="stat-item">
              <span class="stat-icon">📅</span>
              <span class="stat-text">{{ formatDate(book.created_at) }}</span>
            </div>
          </div>
          
          <div class="action-buttons">
            <button @click="startReading" class="read-btn">
              🚀 Mulai Baca
            </button>
            <button @click="toggleFavorite" class="favorite-btn" :class="{ active: isFavorite }">
              {{ isFavorite ? '💖' : '🤍' }} Favorit
            </button>
          </div>
        </div>
      </div>

      <!-- Synopsis Section -->
      <div class="synopsis-section">
        <h2 class="section-title">📖 Tentang Cerita</h2>
        <div class="synopsis-content">
          <p class="synopsis">{{ book.synopsis }}</p>
        </div>
      </div>

      <!-- Reading Section -->
      <div class="reading-section">
        <h2 class="section-title">✨ Baca Cerita</h2>
        <div class="storybook-embed">
          <div class="embed-placeholder" v-if="!book.geminiStorybookUrl && !book.gemini_storybook_url">
            <div class="placeholder-icon">📚</div>
            <h3>Cerita Sedang Dipersiapkan</h3>
            <p>Cerita ini masih dalam tahap persiapan. Silakan kembali lagi nanti!</p>
          </div>
          
          <div v-else class="embed-container">
            <iframe 
              :src="book.geminiStorybookUrl || book.gemini_storybook_url" 
              frameborder="0" 
              class="story-iframe"
              title="Gemini Storybook"
            ></iframe>
            <div class="embed-actions">
              <a :href="book.geminiStorybookUrl || book.gemini_storybook_url" target="_blank" class="external-link">
                🔗 Buka di Tab Baru
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Related Books -->
      <div class="related-section" v-if="relatedBooks.length > 0">
        <h2 class="section-title">🌟 Cerita Serupa</h2>
        <div class="related-books">
          <div class="related-book" v-for="relatedBook in relatedBooks" :key="relatedBook.id">
            <router-link :to="'/book/' + relatedBook.id">
              <img :src="relatedBook.coverImage || relatedBook.cover_image" :alt="relatedBook.title" @error="handleImageError">
              <div class="related-info">
                <h4>{{ relatedBook.title }}</h4>
                <p>{{ relatedBook.author }}</p>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="not-found">
      <div class="not-found-icon">😔</div>
      <h2>Buku Tidak Ditemukan</h2>
      <p>Maaf, buku yang kamu cari tidak dapat ditemukan.</p>
      <router-link to="/collection" class="back-to-collection">
        📚 Lihat Koleksi Lainnya
      </router-link>
    </div>
  </div>
</template>

<script>
import { bookService } from '@/utils/supabase'

export default {
  name: 'BookDetailPage',
  data() {
    return {
      book: null,
      loading: true,
      displayReadCount: 0,
      isFavorite: false,
      relatedBooks: [],
    };
  },
  methods: {
    async fetchBook() {
      this.loading = true;
      try {
        const bookId = parseInt(this.$route.params.id);
        this.book = await bookService.getBookById(bookId);
        
        if (this.book) {
          // Increment read count
          await bookService.incrementReadCount(bookId);
          this.displayReadCount = (this.book.readCount || this.book.read_count || 0) + 1;
          
          // Fetch related books
          await this.fetchRelatedBooks();
          
          // Check if book is in favorites
          this.checkFavoriteStatus();
        }
      } catch (error) {
        console.error('Error fetching book:', error);
      } finally {
        this.loading = false;
      }
    },
    
    async fetchRelatedBooks() {
      try {
        const allBooks = await bookService.getApprovedBooks();
        // Filter out current book and get 3 random related books
        const otherBooks = allBooks.filter(b => b.id !== this.book.id);
        this.relatedBooks = this.shuffleArray(otherBooks).slice(0, 3);
      } catch (error) {
        console.error('Error fetching related books:', error);
      }
    },
    
    shuffleArray(array) {
      const shuffled = [...array];
      for (let i = shuffled.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
      }
      return shuffled;
    },
    
    formatReadCount(count) {
      if (!count) return '0';
      if (count >= 1000) {
        return `${(count / 1000).toFixed(1)}k`;
      }
      return count.toString();
    },
    
    formatDate(dateString) {
      if (!dateString) return 'Tanggal tidak diketahui';
      try {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
      } catch {
        return 'Tanggal tidak valid';
      }
    },
    
    getStatusText(status) {
      const statusMap = {
        approved: 'Disetujui',
        pending: 'Menunggu',
        rejected: 'Ditolak'
      };
      return statusMap[status] || status;
    },
    
    getStatusEmoji(status) {
      const emojiMap = {
        approved: '✅',
        pending: '⏳',
        rejected: '❌'
      };
      return emojiMap[status] || '❓';
    },
    
    handleImageError(event) {
      event.target.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjNmNGY2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSI2MCIgZmlsbD0iIzljYTNhZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPvCfk5o8L3RleHQ+PC9zdmc+';
    },
    
    goBack() {
      this.$router.go(-1);
    },
    
    startReading() {
      const url = this.book.geminiStorybookUrl || this.book.gemini_storybook_url;
      if (url) {
        window.open(url, '_blank');
      } else {
        // Scroll to reading section if no external URL
        document.querySelector('.reading-section').scrollIntoView({ 
          behavior: 'smooth' 
        });
      }
    },
    
    toggleFavorite() {
      this.isFavorite = !this.isFavorite;
      // In a real app, you'd save this to localStorage or backend
      const favorites = JSON.parse(localStorage.getItem('favoriteBooks') || '[]');
      if (this.isFavorite) {
        favorites.push(this.book.id);
      } else {
        const index = favorites.indexOf(this.book.id);
        if (index > -1) favorites.splice(index, 1);
      }
      localStorage.setItem('favoriteBooks', JSON.stringify(favorites));
    },
    
    checkFavoriteStatus() {
      const favorites = JSON.parse(localStorage.getItem('favoriteBooks') || '[]');
      this.isFavorite = favorites.includes(this.book.id);
    }
  },
  
  async mounted() {
    await this.fetchBook();
  },
  
  async beforeRouteUpdate(to, from, next) {
    // Handle route changes within the same component
    next();
    await this.fetchBook();
  }
};
</script>

<style scoped>
.book-detail-page {
  width: 100%;
  max-width: 1000px;
  margin: 0 auto;
}

/* Loading */
.loading {
  text-align: center;
  padding: 4rem 2rem;
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

/* Back Button */
.back-btn {
  background: linear-gradient(135deg, #6b7280, #4b5563);
  color: white;
  border: none;
  padding: 0.8rem 1.5rem;
  border-radius: 25px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-bottom: 2rem;
  font-size: 1rem;
}

.back-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
}

/* Book Header */
.book-header {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 3rem;
  margin-bottom: 3rem;
  background: white;
  padding: 2rem;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.cover-container {
  position: relative;
}

.cover-image {
  width: 100%;
  height: 400px;
  object-fit: cover;
  border-radius: 15px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
}

.cover-image:hover {
  transform: scale(1.02);
}

.cover-overlay {
  position: absolute;
  top: 15px;
  right: 15px;
}

.status-badge {
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
  color: white;
  backdrop-filter: blur(10px);
}

.status-badge.approved {
  background: rgba(16, 185, 129, 0.9);
}

.status-badge.pending {
  background: rgba(245, 158, 11, 0.9);
}

.status-badge.rejected {
  background: rgba(239, 68, 68, 0.9);
}

/* Book Info */
.book-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1.5rem;
}

.book-title {
  font-size: 2.5rem;
  color: #1f2937;
  margin: 0;
  line-height: 1.2;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}

.book-author {
  font-size: 1.3rem;
  color: #10b981;
  margin: 0;
  font-weight: 600;
}

.book-stats {
  display: flex;
  gap: 2rem;
  flex-wrap: wrap;
}

.stat-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: #f3f4f6;
  padding: 0.8rem 1.2rem;
  border-radius: 15px;
}

.stat-icon {
  font-size: 1.2rem;
}

.stat-text {
  font-weight: 600;
  color: #374151;
}

.action-buttons {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.read-btn {
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: white;
  border: none;
  padding: 1rem 2rem;
  border-radius: 25px;
  font-weight: bold;
  font-size: 1.1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
}

.read-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 30px rgba(79, 70, 229, 0.4);
}

.favorite-btn {
  background: white;
  color: #6b7280;
  border: 2px solid #e5e7eb;
  padding: 1rem 2rem;
  border-radius: 25px;
  font-weight: bold;
  font-size: 1.1rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.favorite-btn:hover, .favorite-btn.active {
  border-color: #f43f5e;
  color: #f43f5e;
  background: #fef2f2;
}

/* Content Sections */
.synopsis-section,
.reading-section,
.related-section {
  background: white;
  padding: 2rem;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  margin-bottom: 2rem;
}

.section-title {
  font-size: 1.8rem;
  color: #1f2937;
  margin-bottom: 1.5rem;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.synopsis-content {
  background: linear-gradient(135deg, #f8fafc, #e2e8f0);
  padding: 2rem;
  border-radius: 15px;
  border-left: 5px solid #4f46e5;
}

.synopsis {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #374151;
  margin: 0;
}

/* Storybook Embed */
.storybook-embed {
  background: #f9fafb;
  border-radius: 15px;
  overflow: hidden;
  min-height: 300px;
}

.embed-placeholder {
  text-align: center;
  padding: 4rem 2rem;
  color: #6b7280;
}

.placeholder-icon {
  font-size: 4rem;
  margin-bottom: 1.5rem;
  opacity: 0.6;
}

.embed-placeholder h3 {
  font-size: 1.5rem;
  color: #374151;
  margin-bottom: 1rem;
}

.embed-container {
  position: relative;
}

.story-iframe {
  width: 100%;
  height: 600px;
  border: none;
  border-radius: 15px;
}

.embed-actions {
  padding: 1rem;
  text-align: center;
  background: white;
}

.external-link {
  display: inline-block;
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  padding: 0.8rem 1.5rem;
  border-radius: 25px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.external-link:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
}

/* Related Books */
.related-books {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
}

.related-book {
  background: #f8fafc;
  border-radius: 15px;
  overflow: hidden;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.related-book:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.related-book a {
  text-decoration: none;
  color: inherit;
  display: block;
}

.related-book img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.related-book:hover img {
  transform: scale(1.05);
}

.related-info {
  padding: 1rem;
}

.related-info h4 {
  font-size: 1.1rem;
  color: #1f2937;
  margin: 0 0 0.5rem;
}

.related-info p {
  color: #6b7280;
  margin: 0;
  font-size: 0.9rem;
}

/* Not Found */
.not-found {
  text-align: center;
  padding: 4rem 2rem;
  background: white;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.not-found-icon {
  font-size: 5rem;
  margin-bottom: 2rem;
  opacity: 0.6;
}

.not-found h2 {
  font-size: 2rem;
  color: #1f2937;
  margin-bottom: 1rem;
}

.not-found p {
  color: #6b7280;
  font-size: 1.1rem;
  margin-bottom: 2rem;
}

.back-to-collection {
  display: inline-block;
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: white;
  padding: 1rem 2rem;
  border-radius: 25px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.back-to-collection:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
}

/* Mobile Styles */
@media (max-width: 768px) {
  .book-header {
    grid-template-columns: 1fr;
    gap: 2rem;
    padding: 1.5rem;
    text-align: center;
  }
  
  .cover-image {
    max-width: 250px;
    height: 350px;
    margin: 0 auto;
  }
  
  .book-title {
    font-size: 2rem;
  }
  
  .book-author {
    font-size: 1.1rem;
  }
  
  .book-stats {
    justify-content: center;
  }
  
  .action-buttons {
    justify-content: center;
  }
  
  .synopsis-section,
  .reading-section,
  .related-section {
    padding: 1.5rem;
  }
  
  .section-title {
    font-size: 1.5rem;
  }
  
  .synopsis-content {
    padding: 1.5rem;
  }
  
  .story-iframe {
    height: 400px;
  }
  
  .related-books {
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  }
}

/* Extra Small Mobile */
@media (max-width: 480px) {
  .book-header {
    padding: 1rem;
  }
  
  .cover-image {
    max-width: 200px;
    height: 280px;
  }
  
  .book-title {
    font-size: 1.8rem;
  }
  
  .action-buttons {
    flex-direction: column;
  }
  
  .read-btn,
  .favorite-btn {
    width: 100%;
  }
  
  .synopsis-section,
  .reading-section,
  .related-section {
    padding: 1rem;
  }
  
  .synopsis-content {
    padding: 1rem;
  }
  
  .story-iframe {
    height: 300px;
  }
  
  .related-books {
    grid-template-columns: 1fr;
  }
  
  .not-found {
    padding: 3rem 1rem;
  }
  
  .not-found-icon {
    font-size: 4rem;
  }
  
  .not-found h2 {
    font-size: 1.5rem;
  }
}
</style>
