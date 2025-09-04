<template>
  <div class="home-page">
    <section class="welcome">
      <h1>Selamat Datang di Dunia Cerita!</h1>
      <p>Temukan berbagai macam cerita anak yang menarik dan mendidik.</p>
    </section>

    <section class="book-list">
      <h2>Cerita Populer</h2>
      <div class="book-grid">
        <div class="book-card" v-for="book in approvedBooks" :key="book.id">
          <router-link :to="'/book/' + book.id">
            <img :src="book.coverImage" :alt="book.title">
            <h3>{{ book.title }}</h3>
            <p>oleh {{ book.author }}</p>
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import books from '@/data/books.json';

export default {
  name: 'HomePage',
  data() {
    return {
      books: books,
    };
  },
  computed: {
    approvedBooks() {
      return this.books.filter(book => book.status === 'approved');
    }
  }
};
</script>

<style scoped>
.home-page {
  max-width: 1200px;
  margin: 0 auto;
}

.welcome {
  margin-bottom: 40px;
}

.welcome h1 {
  font-size: 2.5em;
  color: #333;
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
  text-align: left;
}

.book-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.book-card a {
  text-decoration: none;
  color: inherit;
}

.book-card img {
  width: 100%;
  height: 250px;
  object-fit: cover;
}

.book-card h3 {
  margin: 10px;
  font-size: 1.2em;
}

.book-card p {
  margin: 0 10px 10px;
  color: #666;
}

/* Mobile styles */
@media (max-width: 600px) {
  .welcome h1 {
    font-size: 2em;
  }
  .book-grid {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  }
}
</style>
