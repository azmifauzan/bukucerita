<template>
  <div class="upload-page">
    <h1>Unggah Buku Cerita Anda</h1>
    <p>Bagikan cerita yang Anda buat dengan Gemini Storybook kepada dunia!</p>

    <div v-if="submitted" class="success-message">
      <p>Terima kasih! Buku Anda telah berhasil dikirim dan sedang menunggu persetujuan dari admin.</p>
      <button @click="resetForm">Unggah Buku Lain</button>
    </div>

    <form v-else @submit.prevent="submitBook" class="upload-form">
      <div class="form-group">
        <label for="title">Judul Buku</label>
        <input type="text" id="title" v-model="newBook.title" required>
      </div>
      <div class="form-group">
        <label for="author">Nama Pengarang</label>
        <input type="text" id="author" v-model="newBook.author" required>
      </div>
      <div class="form-group">
        <label for="synopsis">Sinopsis</label>
        <textarea id="synopsis" v-model="newBook.synopsis" rows="4" required></textarea>
      </div>
      <div class="form-group">
        <label for="coverImage">URL Gambar Sampul</label>
        <input type="url" id="coverImage" v-model="newBook.coverImage" required>
      </div>
      <div class="form-group">
        <label for="geminiUrl">URL Gemini Storybook</label>
        <input type="url" id="geminiUrl" v-model="newBook.geminiStorybookUrl" required>
      </div>
      <div class="form-note">
        <p><strong>Catatan:</strong> Karena ini adalah versi demo, buku yang Anda unggah tidak akan tersimpan secara permanen. Namun, kami mensimulasikan proses pengiriman untuk Anda.</p>
      </div>
      <button type="submit">Kirim Buku</button>
    </form>
  </div>
</template>

<script>
import books from '@/data/books.json';

export default {
  name: 'UploadPage',
  data() {
    return {
      books: books,
      newBook: {
        title: '',
        author: '',
        synopsis: '',
        coverImage: '',
        geminiStorybookUrl: '',
      },
      submitted: false,
    };
  },
  methods: {
    submitBook() {
      const newBookData = {
        id: this.books.length + 1, // Simple ID generation
        ...this.newBook,
        readCount: 0,
        status: 'pending',
      };
      // In a real app, you'd send this to a server.
      // Here, we just simulate it by adding to the local array.
      this.books.push(newBookData);
      console.log('New book submitted:', newBookData);
      console.log('Updated book list:', this.books);
      this.submitted = true;
    },
    resetForm() {
      this.newBook = {
        title: '',
        author: '',
        synopsis: '',
        coverImage: '',
        geminiStorybookUrl: '',
      };
      this.submitted = false;
    }
  },
};
</script>

<style scoped>
.upload-page {
  max-width: 700px;
  margin: 0 auto;
  text-align: left;
}

.upload-form {
  background: #fff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1em;
}

.form-note {
  background: #f0f0f0;
  padding: 15px;
  border-radius: 4px;
  margin: 20px 0;
  font-size: 0.9em;
  color: #555;
}

button {
  background-color: #42b983;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1em;
  font-weight: bold;
  width: 100%;
}

button:hover {
  background-color: #36a374;
}

.success-message {
  background: #e0f2f1;
  color: #00796b;
  padding: 20px;
  border-radius: 8px;
  text-align: center;
}
.success-message button {
    margin-top: 15px;
    width: auto;
    background-color: #00796b;
}
</style>
