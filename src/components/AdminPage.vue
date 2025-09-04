<template>
  <div class="admin-page">
    <h1>Panel Admin</h1>

    <!-- Statistics Section -->
    <section class="stats-section">
      <h2>Statistik</h2>
      <div class="stats-grid">
        <div class="stat-card">
          <h3>Total Buku</h3>
          <p>{{ totalBooks }}</p>
        </div>
        <div class="stat-card">
          <h3>Buku Disetujui</h3>
          <p>{{ approvedBooksCount }}</p>
        </div>
        <div class="stat-card">
          <h3>Menunggu Persetujuan</h3>
          <p>{{ pendingBooksCount }}</p>
        </div>
      </div>
    </section>

    <!-- Pending Books Section -->
    <section class="book-management">
      <h2>Buku Menunggu Persetujuan</h2>
      <div v-if="pendingBooks.length > 0">
        <table class="book-table">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Pengarang</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="book in pendingBooks" :key="book.id">
              <td>{{ book.title }}</td>
              <td>{{ book.author }}</td>
              <td>
                <button @click="approveBook(book.id)" class="btn-approve">Setujui</button>
                <button @click="rejectBook(book.id)" class="btn-reject">Tolak</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p v-else>Tidak ada buku yang menunggu persetujuan.</p>
    </section>

    <!-- All Books Management Section -->
    <section class="book-management">
      <h2>Kelola Semua Buku</h2>
      <table class="book-table">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Status</th>
            <th>Tindakan</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="book in books" :key="book.id">
            <td>{{ book.title }}</td>
            <td>{{ book.author }}</td>
            <td><span class="status" :class="book.status">{{ book.status }}</span></td>
            <td>
              <button @click="deleteBook(book.id)" class="btn-delete">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import allBooks from '@/data/books.json';

export default {
  name: 'AdminPage',
  data() {
    return {
      books: allBooks,
    };
  },
  computed: {
    totalBooks() {
      return this.books.length;
    },
    approvedBooksCount() {
      return this.books.filter(book => book.status === 'approved').length;
    },
    pendingBooksCount() {
      return this.books.filter(book => book.status === 'pending').length;
    },
    pendingBooks() {
      return this.books.filter(book => book.status === 'pending');
    },
  },
  methods: {
    approveBook(bookId) {
      const book = this.books.find(b => b.id === bookId);
      if (book) {
        book.status = 'approved';
        console.log(`Book ${bookId} approved.`);
      }
    },
    rejectBook(bookId) {
      // Rejection is the same as deletion in this simulation
      this.deleteBook(bookId);
      console.log(`Book ${bookId} rejected and removed.`);
    },
    deleteBook(bookId) {
      this.books = this.books.filter(b => b.id !== bookId);
      console.log(`Book ${bookId} deleted.`);
    },
  },
};
</script>

<style scoped>
.admin-page {
  max-width: 1000px;
  margin: 0 auto;
  text-align: left;
}

h1, h2 {
  border-bottom: 2px solid #42b983;
  padding-bottom: 10px;
  margin-bottom: 20px;
}

.stats-section {
  margin-bottom: 40px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
}

.stat-card {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  text-align: center;
}

.stat-card h3 {
  margin: 0 0 10px;
  font-size: 1.2em;
  color: #555;
}

.stat-card p {
  margin: 0;
  font-size: 2.5em;
  font-weight: bold;
  color: #42b983;
}

.book-management {
  margin-bottom: 40px;
}

.book-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.book-table th, .book-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

.book-table th {
  background-color: #f8f9fa;
}

.book-table button {
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  color: white;
  cursor: pointer;
  margin-right: 5px;
}

.btn-approve { background-color: #28a745; }
.btn-reject { background-color: #dc3545; }
.btn-delete { background-color: #c82333; }

.status {
  padding: 3px 8px;
  border-radius: 12px;
  font-size: 0.8em;
  font-weight: bold;
  color: white;
}
.status.approved { background-color: #28a745; }
.status.pending { background-color: #ffc107; color: #212529; }
</style>
