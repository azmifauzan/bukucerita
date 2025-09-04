<template>
  <div class="book-detail-page" v-if="book">
    <div class="book-header">
      <img :src="book.coverImage" :alt="book.title" class="cover-image">
      <div class="book-info">
        <h1>{{ book.title }}</h1>
        <h2>oleh {{ book.author }}</h2>
        <p class="read-count">Dibaca {{ localReadCount }} kali</p>
      </div>
    </div>
    <div class="book-content">
      <h3>Sinopsis</h3>
      <p class="synopsis">{{ book.synopsis }}</p>
      <h3>Baca Cerita</h3>
      <div class="storybook-embed">
        <!-- Placeholder for Gemini Storybook embed -->
        <p>Embed dari Gemini Storybook akan ditampilkan di sini.</p>
        <a :href="book.geminiStorybookUrl" target="_blank">Lihat Cerita di Gemini</a>
      </div>
    </div>
  </div>
  <div v-else>
    <p>Buku tidak ditemukan.</p>
  </div>
</template>

<script>
import books from '@/data/books.json';

export default {
  name: 'BookDetailPage',
  data() {
    return {
      book: null,
      localReadCount: 0,
    };
  },
  created() {
    const bookId = parseInt(this.$route.params.id);
    this.book = books.find(book => book.id === bookId);
    if (this.book) {
      // Simulate incrementing read count. This won't persist in the JSON file.
      this.localReadCount = this.book.readCount + 1;
    }
  },
};
</script>

<style scoped>
.book-detail-page {
  max-width: 800px;
  margin: 0 auto;
  text-align: left;
}

.book-header {
  display: flex;
  margin-bottom: 30px;
  gap: 20px;
}

.cover-image {
  width: 200px;
  height: 300px;
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.book-info h1 {
  margin: 0 0 10px;
  font-size: 2.5em;
}

.book-info h2 {
  margin: 0 0 20px;
  font-size: 1.5em;
  font-weight: normal;
  color: #555;
}

.read-count {
  color: #777;
  font-style: italic;
}

.book-content h3 {
  border-bottom: 2px solid #42b983;
  padding-bottom: 5px;
  margin-bottom: 15px;
}

.synopsis {
  line-height: 1.6;
  margin-bottom: 30px;
}

.storybook-embed {
  border: 1px dashed #ccc;
  padding: 20px;
  text-align: center;
  background: #f9f9f9;
}

/* Mobile styles */
@media (max-width: 600px) {
  .book-header {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .book-info h1 {
    font-size: 2em;
  }

  .book-info h2 {
    font-size: 1.2em;
  }
}
</style>
