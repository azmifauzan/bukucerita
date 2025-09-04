<template>
  <div class="collection-page">
    <h1>Koleksi Buku Cerita</h1>
    <div class="search-bar">
      <input type="text" v-model="searchQuery" placeholder="Cari buku berdasarkan judul, penulis, atau sinopsis...">
    </div>
    <div class="book-grid">
      <div class="book-card" v-for="book in filteredBooks" :key="book.id">
        <router-link :to="'/book/' + book.id">
          <img :src="book.coverImage" :alt="book.title">
          <div class="book-info">
            <h3>{{ book.title }}</h3>
            <p>oleh {{ book.author }}</p>
            <span class="status" :class="book.status">{{ book.status }}</span>
          </div>
        </router-link>
      </div>
    </div>
     <div v-if="filteredBooks.length === 0" class="no-results">
      <p>Tidak ada buku yang cocok dengan pencarian Anda.</p>
    </div>
  </div>
</template>

<script>
import books from '@/data/books.json';

export default {
  name: 'BookCollectionPage',
  data() {
    return {
      books: books,
      searchQuery: '',
    };
  },
  computed: {
    filteredBooks() {
      if (!this.searchQuery) {
        return this.books;
      }
      const query = this.searchQuery.toLowerCase();
      return this.books.filter(book => {
        return (
          book.title.toLowerCase().includes(query) ||
          book.author.toLowerCase().includes(query) ||
          book.synopsis.toLowerCase().includes(query)
        );
      });
    },
  },
};
</script>

<style scoped>
.collection-page {
  max-width: 1200px;
  margin: 0 auto;
}

.search-bar {
  margin-bottom: 30px;
}

.search-bar input {
  width: 100%;
  padding: 12px;
  font-size: 1em;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.book-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 20px;
}

.book-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.2s;
  background: #fff;
}

.book-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.book-card a {
  text-decoration: none;
  color: inherit;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.book-card img {
  width: 100%;
  height: 250px;
  object-fit: cover;
}

.book-info {
  padding: 15px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.book-info h3 {
  margin: 0 0 5px;
  font-size: 1.1em;
}

.book-info p {
  margin: 0 0 10px;
  color: #666;
  font-size: 0.9em;
}

.status {
  margin-top: auto;
  padding: 3px 8px;
  border-radius: 12px;
  font-size: 0.8em;
  font-weight: bold;
  align-self: flex-start;
}

.status.approved {
  background-color: #e0f2f1;
  color: #00796b;
}

.status.pending {
  background-color: #fff3e0;
  color: #ef6c00;
}

.no-results {
  text-align: center;
  margin-top: 50px;
  color: #777;
}
</style>
