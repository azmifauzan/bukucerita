<template>
  <div class="upload-page">
    <!-- Page Header -->
    <div class="page-header">
      <h1>📤 Bagikan Cerita Kamu!</h1>
      <p>Buat dunia lebih berwarna dengan cerita-cerita kreatif mu. Yuk, berbagi kebahagiaan melalui kata-kata!</p>
    </div>

    <!-- Success Message -->
    <div v-if="submitted" class="success-section">
      <div class="success-animation">
        <div class="checkmark">✅</div>
        <div class="confetti">🎉</div>
      </div>
      <h2>Yeay! Cerita Berhasil Dikirim!</h2>
      <p class="success-text">
        Terima kasih sudah berbagi cerita yang luar biasa! 🌟<br>
        Tim kami sedang mereview cerita kamu dan akan segera menerbitkannya.
      </p>
      <div class="success-stats">
        <div class="stat">
          <span class="stat-icon">📚</span>
          <span class="stat-text">Cerita ke-{{ books.length + 1 }}</span>
        </div>
        <div class="stat">
          <span class="stat-icon">⏰</span>
          <span class="stat-text">Review dalam 24 jam</span>
        </div>
      </div>
      <div class="success-actions">
        <button @click="resetForm" class="primary-btn">
          ✨ Bagikan Cerita Lain
        </button>
        <router-link to="/collection" class="secondary-btn">
          📖 Lihat Koleksi
        </router-link>
      </div>
    </div>

    <!-- Upload Form -->
    <form v-else @submit.prevent="submitBook" class="upload-form">
      <!-- Progress Steps -->
      <div class="form-progress">
        <div class="progress-step" :class="{ active: currentStep >= 1, completed: currentStep > 1 }">
          <div class="step-number">1</div>
          <span>Info Dasar</span>
        </div>
        <div class="progress-step" :class="{ active: currentStep >= 2, completed: currentStep > 2 }">
          <div class="step-number">2</div>
          <span>Detail Cerita</span>
        </div>
        <div class="progress-step" :class="{ active: currentStep >= 3 }">
          <div class="step-number">3</div>
          <span>Media & Link</span>
        </div>
      </div>

      <!-- Step 1: Basic Info -->
      <div v-show="currentStep === 1" class="form-step">
        <div class="step-header">
          <h2>📝 Informasi Dasar</h2>
          <p>Ceritakan kepada kami tentang buku cerita kamu</p>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="title">
              <span class="label-icon">📖</span>
              Judul Cerita
            </label>
            <input 
              type="text" 
              id="title" 
              v-model="newBook.title" 
              placeholder="Contoh: Petualangan di Hutan Ajaib"
              required
              maxlength="100"
            >
            <div class="char-count">{{ newBook.title.length }}/100 karakter</div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="author">
              <span class="label-icon">👤</span>
              Nama Pengarang
            </label>
            <input 
              type="text" 
              id="author" 
              v-model="newBook.author" 
              placeholder="Nama kamu sebagai pengarang"
              required
              maxlength="50"
            >
            <div class="char-count">{{ newBook.author.length }}/50 karakter</div>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" @click="nextStep" class="next-btn">
            Lanjut ➡️
          </button>
        </div>
      </div>

      <!-- Step 2: Story Details -->
      <div v-show="currentStep === 2" class="form-step">
        <div class="step-header">
          <h2>📚 Detail Cerita</h2>
          <p>Berikan gambaran menarik tentang cerita kamu</p>
        </div>

        <div class="form-group full-width">
          <label for="synopsis">
            <span class="label-icon">📜</span>
            Sinopsis Cerita
          </label>
          <textarea 
            id="synopsis" 
            v-model="newBook.synopsis" 
            rows="6" 
            placeholder="Deskripsikan cerita kamu dengan menarik... Apa yang terjadi? Siapa tokoh utamanya? Apa pesan moral yang ingin disampaikan?"
            required
            maxlength="500"
          ></textarea>
          <div class="char-count">{{ newBook.synopsis.length }}/500 karakter</div>
        </div>

        <div class="form-actions">
          <button type="button" @click="prevStep" class="prev-btn">
            ⬅️ Kembali
          </button>
          <button type="button" @click="nextStep" class="next-btn">
            Lanjut ➡️
          </button>
        </div>
      </div>

      <!-- Step 3: Media & Links -->
      <div v-show="currentStep === 3" class="form-step">
        <div class="step-header">
          <h2>🎨 Media & Link</h2>
          <p>Tambahkan gambar sampul dan link cerita kamu</p>
        </div>

        <div class="form-group">
          <label for="coverImage">
            <span class="label-icon">🖼️</span>
            URL Gambar Sampul
          </label>
          <input 
            type="url" 
            id="coverImage" 
            v-model="newBook.coverImage" 
            placeholder="https://contoh.com/gambar-sampul.jpg"
            required
          >
          <div class="input-help">
            💡 Gunakan gambar dengan rasio 3:4 untuk hasil terbaik
          </div>
          <!-- Image Preview -->
          <div v-if="newBook.coverImage" class="image-preview">
            <img :src="newBook.coverImage" alt="Preview sampul" @error="imageError = true" @load="imageError = false">
            <div v-if="imageError" class="image-error">❌ Gambar tidak dapat dimuat</div>
          </div>
        </div>

        <div class="form-group">
          <label for="geminiUrl">
            <span class="label-icon">🤖</span>
            URL Gemini Storybook
          </label>
          <input 
            type="url" 
            id="geminiUrl" 
            v-model="newBook.geminiStorybookUrl" 
            placeholder="https://gemini.google.com/share/..."
            required
          >
          <div class="input-help">
            💡 Link dari Gemini Storybook yang sudah dibuat
          </div>
        </div>

        <div class="form-note">
          <div class="note-icon">📋</div>
          <div class="note-content">
            <h3>Sebelum mengirim:</h3>
            <ul>
              <li>✅ Pastikan cerita sudah selesai dan layak dibaca anak-anak</li>
              <li>✅ Gambar sampul terlihat jelas dan menarik</li>
              <li>✅ Link Gemini Storybook dapat diakses</li>
              <li>✅ Cerita mengandung nilai positif dan edukatif</li>
            </ul>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" @click="prevStep" class="prev-btn">
            ⬅️ Kembali
          </button>
          <button type="submit" class="submit-btn" :disabled="isSubmitting">
            <span v-if="!isSubmitting">🚀 Bagikan Cerita</span>
            <span v-else>
              <span class="spinner">🔄</span> Mengirim...
            </span>
          </button>
        </div>
      </div>
    </form>

    <!-- Upload Guidelines -->
    <div class="guidelines-section">
      <h2>📝 Panduan Upload</h2>
      <div class="guidelines-grid">
        <div class="guideline-card">
          <div class="guideline-icon">🎯</div>
          <h3>Target Pembaca</h3>
          <p>Cerita untuk anak-anak usia 4-12 tahun dengan bahasa yang mudah dipahami</p>
        </div>
        <div class="guideline-card">
          <div class="guideline-icon">💫</div>
          <h3>Konten Positif</h3>
          <p>Pastikan cerita mengandung nilai-nilai positif dan pesan moral yang baik</p>
        </div>
        <div class="guideline-card">
          <div class="guideline-icon">🎨</div>
          <h3>Visual Menarik</h3>
          <p>Gunakan gambar sampul yang colorful dan eye-catching untuk anak-anak</p>
        </div>
        <div class="guideline-card">
          <div class="guideline-icon">📱</div>
          <h3>Format Digital</h3>
          <p>Cerita dalam format Gemini Storybook yang interaktif dan engaging</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { bookService } from '@/utils/supabase'

export default {
  name: 'UploadPage',
  data() {
    return {
      books: [],
      newBook: {
        title: '',
        author: '',
        synopsis: '',
        coverImage: '',
        geminiStorybookUrl: '',
      },
      submitted: false,
      isSubmitting: false,
      currentStep: 1,
      imageError: false,
    };
  },
  computed: {
    isStep1Valid() {
      return this.newBook.title.trim() && this.newBook.author.trim();
    },
    isStep2Valid() {
      return this.newBook.synopsis.trim();
    },
    isStep3Valid() {
      return this.newBook.coverImage.trim() && this.newBook.geminiStorybookUrl.trim();
    }
  },
  methods: {
    async submitBook() {
      if (!this.isStep3Valid) return;

      this.isSubmitting = true;
      try {
        const newBookData = {
          title: this.newBook.title.trim(),
          author: this.newBook.author.trim(),
          synopsis: this.newBook.synopsis.trim(),
          cover_image: this.newBook.coverImage.trim(),
          gemini_storybook_url: this.newBook.geminiStorybookUrl.trim(),
          status: 'pending',
          read_count: 0,
        };

        // Try to add to Supabase
        await bookService.addBook(newBookData);
        
        console.log('New book submitted:', newBookData);
        this.submitted = true;
        
        // Show success animation
        setTimeout(() => {
          this.scrollToTop();
        }, 100);
        
      } catch (error) {
        console.error('Error submitting book:', error);
        
        // Fallback: simulate successful submission
        const fallbackData = {
          id: Date.now(), // Use timestamp as ID
          ...this.newBook,
          readCount: 0,
          status: 'pending',
        };
        
        this.books.push(fallbackData);
        this.submitted = true;
        
        alert('Buku berhasil dikirim! (Mode demo - data tidak tersimpan permanen)');
      } finally {
        this.isSubmitting = false;
      }
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
      this.currentStep = 1;
      this.imageError = false;
      this.scrollToTop();
    },
    
    nextStep() {
      if (this.currentStep === 1 && !this.isStep1Valid) return;
      if (this.currentStep === 2 && !this.isStep2Valid) return;
      
      if (this.currentStep < 3) {
        this.currentStep++;
        this.scrollToTop();
      }
    },
    
    prevStep() {
      if (this.currentStep > 1) {
        this.currentStep--;
        this.scrollToTop();
      }
    },
    
    scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    
    async loadBooksCount() {
      try {
        const allBooks = await bookService.getAllBooks();
        this.books = allBooks;
      } catch (error) {
        console.error('Error loading books count:', error);
        // Fallback to static data
        const { default: staticBooks } = await import('@/data/books.json');
        this.books = staticBooks;
      }
    }
  },
  
  async mounted() {
    await this.loadBooksCount();
  }
};
</script>

<style scoped>
.upload-page {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
}

/* Page Header */
.page-header {
  text-align: center;
  padding: 3rem 2rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 20px;
  margin: -2rem -1rem 3rem;
  box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
}

.page-header h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.page-header p {
  font-size: 1.2rem;
  opacity: 0.9;
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
}

/* Success Section */
.success-section {
  text-align: center;
  background: white;
  padding: 4rem 2rem;
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
  position: relative;
  overflow: hidden;
}

.success-animation {
  margin-bottom: 2rem;
  position: relative;
}

.checkmark {
  font-size: 4rem;
  animation: bounceIn 0.6s ease;
  display: block;
  margin-bottom: 1rem;
}

.confetti {
  font-size: 2rem;
  position: absolute;
  top: -10px;
  right: 50%;
  animation: confettifall 1s ease-out;
}

@keyframes bounceIn {
  0% { transform: scale(0); }
  50% { transform: scale(1.2); }
  100% { transform: scale(1); }
}

@keyframes confettifall {
  0% { transform: translateY(-50px) rotate(0deg); opacity: 1; }
  100% { transform: translateY(100px) rotate(360deg); opacity: 0; }
}

.success-section h2 {
  font-size: 2.2rem;
  color: #10b981;
  margin-bottom: 1.5rem;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.success-text {
  font-size: 1.1rem;
  color: #6b7280;
  line-height: 1.8;
  margin-bottom: 2rem;
}

.success-stats {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-bottom: 3rem;
  flex-wrap: wrap;
}

.stat {
  background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
  padding: 1.5rem;
  border-radius: 15px;
  display: flex;
  align-items: center;
  gap: 1rem;
  min-width: 180px;
}

.stat-icon {
  font-size: 1.8rem;
}

.stat-text {
  font-weight: 600;
  color: #374151;
}

.success-actions {
  display: flex;
  gap: 1.5rem;
  justify-content: center;
  flex-wrap: wrap;
}

.primary-btn, .secondary-btn {
  padding: 1rem 2rem;
  border-radius: 25px;
  font-weight: 600;
  font-size: 1.1rem;
  text-decoration: none;
  transition: all 0.3s ease;
  display: inline-block;
}

.primary-btn {
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: white;
  border: none;
  cursor: pointer;
  box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
}

.primary-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
}

.secondary-btn {
  background: white;
  color: #4f46e5;
  border: 2px solid #4f46e5;
}

.secondary-btn:hover {
  background: #4f46e5;
  color: white;
  transform: translateY(-2px);
}

/* Upload Form */
.upload-form {
  background: white;
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

/* Form Progress */
.form-progress {
  display: flex;
  justify-content: center;
  padding: 2rem;
  background: linear-gradient(135deg, #f8fafc, #e2e8f0);
  gap: 2rem;
}

.progress-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  opacity: 0.5;
  transition: all 0.3s ease;
}

.progress-step.active {
  opacity: 1;
}

.progress-step.completed {
  opacity: 0.8;
}

.step-number {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: #d1d5db;
  color: #6b7280;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 1.2rem;
  transition: all 0.3s ease;
}

.progress-step.active .step-number {
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: white;
  box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.progress-step.completed .step-number {
  background: #10b981;
  color: white;
}

.progress-step span {
  font-weight: 600;
  color: #6b7280;
  text-align: center;
}

.progress-step.active span {
  color: #1f2937;
}

/* Form Steps */
.form-step {
  padding: 3rem 2rem;
}

.step-header {
  text-align: center;
  margin-bottom: 3rem;
}

.step-header h2 {
  font-size: 2rem;
  color: #1f2937;
  margin-bottom: 1rem;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.step-header p {
  color: #6b7280;
  font-size: 1.1rem;
}

/* Form Elements */
.form-row {
  display: grid;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

.form-group label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  color: #374151;
  font-size: 1.1rem;
}

.label-icon {
  font-size: 1.2rem;
}

.form-group input,
.form-group textarea {
  padding: 1rem;
  border: 2px solid #e5e7eb;
  border-radius: 15px;
  font-size: 1rem;
  font-family: inherit;
  transition: all 0.3s ease;
  background: #f9fafb;
}

.form-group input:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #4f46e5;
  background: white;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-group textarea {
  resize: vertical;
  min-height: 120px;
  line-height: 1.6;
}

.char-count {
  font-size: 0.9rem;
  color: #6b7280;
  text-align: right;
  margin-top: 0.25rem;
}

.input-help {
  font-size: 0.9rem;
  color: #10b981;
  margin-top: 0.5rem;
}

/* Image Preview */
.image-preview {
  margin-top: 1rem;
  text-align: center;
}

.image-preview img {
  max-width: 200px;
  max-height: 250px;
  border-radius: 10px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  transition: transform 0.3s ease;
}

.image-preview img:hover {
  transform: scale(1.05);
}

.image-error {
  color: #ef4444;
  font-size: 0.9rem;
  margin-top: 0.5rem;
}

/* Form Note */
.form-note {
  background: linear-gradient(135deg, #fef3c7, #fed7aa);
  border-radius: 15px;
  padding: 2rem;
  margin: 2rem 0;
  display: flex;
  gap: 1rem;
  align-items: flex-start;
}

.note-icon {
  font-size: 2rem;
  flex-shrink: 0;
}

.note-content h3 {
  color: #92400e;
  margin-bottom: 1rem;
  font-size: 1.2rem;
}

.note-content ul {
  margin: 0;
  padding-left: 1.5rem;
  color: #78350f;
}

.note-content li {
  margin-bottom: 0.5rem;
  line-height: 1.4;
}

/* Form Actions */
.form-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  margin-top: 3rem;
  flex-wrap: wrap;
}

.form-actions button {
  padding: 1rem 2rem;
  border: none;
  border-radius: 25px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  min-width: 140px;
}

.prev-btn {
  background: #f3f4f6;
  color: #6b7280;
}

.prev-btn:hover {
  background: #e5e7eb;
  transform: translateY(-2px);
}

.next-btn {
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: white;
  box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.next-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
}

.submit-btn {
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
  flex: 1;
}

.submit-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.submit-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

.spinner {
  display: inline-block;
  animation: spin 1s linear infinite;
}

/* Guidelines Section */
.guidelines-section {
  background: white;
  padding: 3rem 2rem;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  margin-top: 3rem;
}

.guidelines-section h2 {
  text-align: center;
  font-size: 2rem;
  color: #1f2937;
  margin-bottom: 2rem;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.guidelines-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
}

.guideline-card {
  background: linear-gradient(135deg, #f8fafc, #e2e8f0);
  padding: 2rem;
  border-radius: 15px;
  text-align: center;
  transition: all 0.3s ease;
  border-left: 4px solid #4f46e5;
}

.guideline-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.guideline-icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  display: block;
}

.guideline-card h3 {
  font-size: 1.3rem;
  color: #1f2937;
  margin-bottom: 1rem;
}

.guideline-card p {
  color: #6b7280;
  line-height: 1.6;
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
  
  .success-section {
    padding: 3rem 1rem;
  }
  
  .success-stats {
    flex-direction: column;
    align-items: center;
    gap: 1rem;
  }
  
  .success-actions {
    flex-direction: column;
    width: 100%;
  }
  
  .primary-btn, .secondary-btn {
    width: 100%;
    text-align: center;
  }
  
  .form-progress {
    padding: 1.5rem 1rem;
    gap: 1rem;
  }
  
  .form-step {
    padding: 2rem 1rem;
  }
  
  .step-header h2 {
    font-size: 1.5rem;
  }
  
  .form-actions {
    flex-direction: column;
    width: 100%;
  }
  
  .form-actions button {
    width: 100%;
  }
  
  .guidelines-section {
    padding: 2rem 1rem;
    margin-top: 2rem;
  }
  
  .guidelines-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
}

/* Extra Small Mobile */
@media (max-width: 480px) {
  .form-progress {
    gap: 0.5rem;
  }
  
  .progress-step span {
    font-size: 0.8rem;
  }
  
  .step-number {
    width: 40px;
    height: 40px;
    font-size: 1rem;
  }
  
  .checkmark {
    font-size: 3rem;
  }
  
  .success-section h2 {
    font-size: 1.8rem;
  }
  
  .stat {
    min-width: auto;
    width: 100%;
  }
}
</style>
