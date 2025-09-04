<template>
  <div class="collection-page">
    <div class="page-header">
      <h1>📚 Koleksi Buku Cerita</h1>
      <p>Temukan cerita favorit kamu di sini!</p>
    </div>

    <div class="search-section">
      <div class="search-container">
        <div class="search-icon">🔍</div>
        <input 
          type="text" 
          v-model="searchQuery" 
          placeholder="Cari berdasarkan judul, penulis, atau cerita..."
          class="search-input"
        >
        <button v-if="searchQuery" @click="clearSearch" class="clear-btn">❌</button>
      </div>
      <div class="search-filters">
        <button 
          :class="['filter-btn', { active: statusFilter === 'all' }]"
          @click="setStatusFilter('all')"
        >
          🌟 Semua
        </button>
        <button 
          :class="['filter-btn', { active: statusFilter === 'approved' }]"
          @click="setStatusFilter('approved')"
        >
          ✅ Disetujui
        </button>
        <button 
          :class="['filter-btn', { active: statusFilter === 'pending' }]"
          @click="setStatusFilter('pending')"
        >
          ⏳ Menunggu
        </button>
      </div>
    </div>

    <div class="results-info" v-if="searchQuery || statusFilter !== 'all'">
      <p>
        <span v-if="searchQuery">Hasil pencarian untuk "<strong>{{ searchQuery }}</strong>"</span>
        <span v-if="statusFilter !== 'all'"> ({{ getStatusText(statusFilter) }})</span>
        : {{ filteredBooks.length }} buku
      </p>
    </div>

    <div class="loading" v-if="loading">
      <div class="spinner">🔄</div>
      <p>Memuat koleksi buku...</p>
    </div>

    <div class="book-grid" v-else-if="filteredBooks.length > 0">
      <div class="book-card" v-for="book in paginatedBooks" :key="book.id">
        <router-link :to="'/book/' + book.id" @click="incrementReadCount(book.id)">
          <div class="book-cover">
            <img :src="book.coverImage || book.cover_image" :alt="book.title" @error="handleImageError">
            <div class="book-status" :class="book.status">
              {{ getStatusEmoji(book.status) }}
            </div>
            <div class="read-count">
              👀 {{ formatReadCount(book.readCount || book.read_count) }}
            </div>
          </div>
          <div class="book-info">
            <h3>{{ book.title }}</h3>
            <p class="author">📝 {{ book.author }}</p>
            <p class="synopsis">{{ truncateSynopsis(book.synopsis) }}</p>
            <div class="book-meta">
              <span class="status-badge" :class="book.status">
                {{ getStatusText(book.status) }}
              </span>
            </div>
          </div>
        </router-link>
      </div>
    </div>

    <div v-else class="no-results">
      <div class="no-results-icon">🔍</div>
      <h3>Tidak ada buku yang ditemukan</h3>
      <p v-if="searchQuery">Coba dengan kata kunci yang berbeda</p>
      <p v-else>Belum ada buku dalam kategori ini</p>
      <button @click="clearFilters" class="reset-btn">🔄 Reset Pencarian</button>
    </div>

    <div class="pagination" v-if="totalPages > 1">
      <button 
        :disabled="currentPage === 1"
        @click="currentPage--"
        class="page-btn"
      >
        ⬅️ Sebelumnya
      </button>
      <span class="page-info">
        Halaman {{ currentPage }} dari {{ totalPages }}
      </span>
      <button 
        :disabled="currentPage === totalPages"
        @click="currentPage++"
        class="page-btn"
      >
        Selanjutnya ➡️
      </button>
    </div>
  </div>
</template>

<script>
import { bookService } from '@/utils/supabase'

export default {
  name: 'BookCollectionPage',
  data() {
    return {
      books: [],
      searchQuery: '',
      statusFilter: 'all',
      loading: true,
      currentPage: 1,
      booksPerPage: 12,
    };
  },
  computed: {
    filteredBooks() {
      let filtered = [...this.books];

      // Filter by status
      if (this.statusFilter !== 'all') {
        filtered = filtered.filter(book => book.status === this.statusFilter);
      }

      // Filter by search query
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(book => {
          return (
            book.title.toLowerCase().includes(query) ||
            book.author.toLowerCase().includes(query) ||
            book.synopsis.toLowerCase().includes(query)
          );
        });
      }

      return filtered;
    },
    totalPages() {
      return Math.ceil(this.filteredBooks.length / this.booksPerPage);
    },
    paginatedBooks() {
      const start = (this.currentPage - 1) * this.booksPerPage;
      const end = start + this.booksPerPage;
      return this.filteredBooks.slice(start, end);
    }
  },
  watch: {
    filteredBooks() {
      // Reset to first page when filters change
      this.currentPage = 1;
    }
  },
  methods: {
    async fetchBooks() {
      this.loading = true;
      try {
        this.books = await bookService.getAllBooks();
      } catch (error) {
        console.error('Error fetching books:', error);
        // Fallback to static data if needed
        const { default: staticBooks } = await import('@/data/books.json');
        this.books = staticBooks;
      } finally {
        this.loading = false;
      }
    },
    setStatusFilter(status) {
      this.statusFilter = status;
    },
    clearSearch() {
      this.searchQuery = '';
    },
    clearFilters() {
      this.searchQuery = '';
      this.statusFilter = 'all';
    },
    getStatusText(status) {
      const statusMap = {
        approved: 'Disetujui',
        pending: 'Menunggu',
        rejected: 'Ditolak',
        all: 'Semua'
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
    formatReadCount(count) {
      if (!count) return '0';
      if (count >= 1000) {
        return `${(count / 1000).toFixed(1)}k`;
      }
      return count.toString();
    },
    truncateSynopsis(synopsis) {
      if (!synopsis) return '';
      return synopsis.length > 100 ? synopsis.substring(0, 100) + '...' : synopsis;
    },
    handleImageError(event) {
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
.collection-page {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
}

/* Page Header */
.page-header {
  text-align: center;
  margin-bottom: 3rem;
  padding: 2rem 0;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 20px;
  margin: -2rem -1rem 3rem;
}

.page-header h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.page-header p {
  font-size: 1.2rem;
  opacity: 0.9;
}

/* Search Section */
.search-section {
  background: white;
  padding: 2rem;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  margin-bottom: 3rem;
}

.search-container {
  position: relative;
  margin-bottom: 1.5rem;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  font-size: 1.2rem;
  color: #6b7280;
  z-index: 2;
}

.search-input {
  width: 100%;
  padding: 1rem 3rem 1rem 3.5rem;
  font-size: 1.1rem;
  border: 2px solid #e5e7eb;
  border-radius: 50px;
  background: #f9fafb;
  transition: all 0.3s ease;
  font-family: inherit;
}

.search-input:focus {
  outline: none;
  border-color: #4f46e5;
  background: white;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.clear-btn {
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  font-size: 1rem;
  cursor: pointer;
  opacity: 0.6;
  transition: opacity 0.3s;
  padding: 0.2rem;
}

.clear-btn:hover {
  opacity: 1;
}

/* Search Filters */
.search-filters {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.filter-btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 25px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  background: #f3f4f6;
  color: #374151;
}

.filter-btn:hover {
  background: #e5e7eb;
  transform: translateY(-2px);
}

.filter-btn.active {
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: white;
  box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

/* Results Info */
.results-info {
  text-align: center;
  margin-bottom: 2rem;
  color: #6b7280;
  font-size: 1.1rem;
}

.results-info strong {
  color: #1f2937;
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

/* Book Grid */
.book-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.book-card a {
  text-decoration: none;
  color: inherit;
  display: block;
  height: 100%;
}

.book-cover {
  position: relative;
  height: 280px;
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

.book-status {
  position: absolute;
  top: 15px;
  left: 15px;
  font-size: 1.5rem;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(5px);
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
  display: flex;
  flex-direction: column;
  height: calc(100% - 280px);
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
  flex-grow: 1;
  margin-bottom: 1rem;
}

.book-meta {
  margin-top: auto;
}

.status-badge {
  padding: 0.5rem 1rem;
  border-radius: 15px;
  font-size: 0.85rem;
  font-weight: 600;
  display: inline-block;
}

.status-badge.approved {
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
}

.status-badge.pending {
  background: linear-gradient(135deg, #f59e0b, #d97706);
  color: white;
}

.status-badge.rejected {
  background: linear-gradient(135deg, #ef4444, #dc2626);
  color: white;
}

/* No Results */
.no-results {
  text-align: center;
  padding: 4rem 2rem;
  background: white;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.no-results-icon {
  font-size: 4rem;
  margin-bottom: 1.5rem;
  opacity: 0.5;
}

.no-results h3 {
  font-size: 1.8rem;
  color: #1f2937;
  margin-bottom: 1rem;
}

.no-results p {
  color: #6b7280;
  font-size: 1.1rem;
  margin-bottom: 2rem;
}

.reset-btn {
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: white;
  border: none;
  padding: 1rem 2rem;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.reset-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
}

/* Pagination */
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 2rem;
  padding: 2rem 0;
}

.page-btn {
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: white;
  border: none;
  padding: 1rem 1.5rem;
  border-radius: 50px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.page-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
}

.page-btn:disabled {
  background: #d1d5db;
  color: #9ca3af;
  cursor: not-allowed;
  box-shadow: none;
}

.page-info {
  font-weight: 600;
  color: #1f2937;
  font-size: 1.1rem;
}

/* Mobile Styles */
@media (max-width: 768px) {
  .page-header {
    margin: -1rem -0.5rem 2rem;
    padding: 2rem 1rem;
    border-radius: 15px;
  }
  
  .page-header h1 {
    font-size: 2rem;
  }
  
  .page-header p {
    font-size: 1rem;
  }
  
  .search-section {
    padding: 1.5rem;
    margin: 0 -0.5rem 2rem;
    border-radius: 15px;
  }
  
  .search-filters {
    gap: 0.8rem;
  }
  
  .filter-btn {
    font-size: 0.9rem;
    padding: 0.6rem 1.2rem;
  }
  
  .book-grid {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
  }
  
  .book-cover {
    height: 250px;
  }
  
  .book-info {
    height: calc(100% - 250px);
    padding: 1.2rem;
  }
  
  .pagination {
    flex-direction: column;
    gap: 1rem;
  }
  
  .page-btn {
    padding: 0.8rem 1.2rem;
    font-size: 0.9rem;
  }
}

/* Extra Small Mobile */
@media (max-width: 480px) {
  .search-container {
    margin-bottom: 1rem;
  }
  
  .search-input {
    padding: 0.8rem 2.5rem 0.8rem 3rem;
    font-size: 1rem;
  }
  
  .filter-btn {
    font-size: 0.85rem;
    padding: 0.5rem 1rem;
  }
  
  .book-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  
  .book-cover {
    height: 220px;
  }
  
  .book-info {
    height: calc(100% - 220px);
    padding: 1rem;
  }
  
  .book-info h3 {
    font-size: 1.2rem;
  }
  
  .no-results {
    padding: 3rem 1rem;
  }
  
  .no-results-icon {
    font-size: 3rem;
  }
  
  .no-results h3 {
    font-size: 1.5rem;
  }
}
</style>
