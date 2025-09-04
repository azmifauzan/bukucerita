<template>
  <div id="app">
    <header>
      <nav class="main-nav">
        <div class="logo">
          <h1>📚 BukuCerita</h1>
        </div>
        <div class="nav-links" :class="{ active: showMobileMenu }">
          <router-link to="/" @click="closeMobileMenu">🏠 Beranda</router-link>
          <router-link to="/collection" @click="closeMobileMenu">📖 Koleksi</router-link>
          <router-link to="/upload" @click="closeMobileMenu">📤 Upload</router-link>
          <router-link to="/admin" @click="closeMobileMenu">⚙️ Admin</router-link>
        </div>
        <button class="mobile-menu-btn" @click="toggleMobileMenu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </nav>
    </header>
    <main>
      <router-view />
    </main>
    <footer class="main-footer">
      <div class="footer-content">
        <p>✨ Temukan keajaiban dalam setiap cerita ✨</p>
        <p>&copy; 2025 BukuCerita - Dunia Penuh Warna</p>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      showMobileMenu: false
    }
  },
  methods: {
    toggleMobileMenu() {
      this.showMobileMenu = !this.showMobileMenu;
    },
    closeMobileMenu() {
      this.showMobileMenu = false;
    }
  }
};
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Comic Sans MS', 'Trebuchet MS', Arial, sans-serif;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  min-height: 100vh;
}

#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background: linear-gradient(135deg, #ff9a8b 0%, #ffecd2 50%, #a8edea 100%);
  animation: gradientShift 15s ease infinite;
}

@keyframes gradientShift {
  0%, 100% { background: linear-gradient(135deg, #ff9a8b 0%, #ffecd2 50%, #a8edea 100%); }
  33% { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 50%, #ffecd2 100%); }
  66% { background: linear-gradient(135deg, #ffecd2 0%, #a8edea 50%, #ff9a8b 100%); }
}

/* Header Styles */
header {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 1000;
}

.main-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.logo h1 {
  color: #4f46e5;
  font-size: 1.8rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  margin: 0;
}

.nav-links {
  display: flex;
  gap: 2rem;
  align-items: center;
}

.nav-links a {
  color: #374151;
  text-decoration: none;
  font-weight: 600;
  font-size: 1.1rem;
  padding: 0.5rem 1rem;
  border-radius: 25px;
  transition: all 0.3s ease;
  background: linear-gradient(135deg, #fbbf24, #f59e0b);
  color: white;
  box-shadow: 0 2px 10px rgba(245, 158, 11, 0.3);
}

.nav-links a:hover {
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
}

.nav-links a.router-link-exact-active {
  background: linear-gradient(135deg, #10b981, #059669);
  box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

/* Mobile Menu Button */
.mobile-menu-btn {
  display: none;
  flex-direction: column;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
  z-index: 1001;
}

.mobile-menu-btn span {
  width: 25px;
  height: 3px;
  background: #4f46e5;
  margin: 3px 0;
  transition: 0.3s;
  border-radius: 3px;
}

/* Main Content */
main {
  flex: 1;
  padding: 2rem 1rem;
  max-width: 1200px;
  width: 100%;
  margin: 0 auto;
}

/* Footer */
.main-footer {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  padding: 2rem;
  text-align: center;
  margin-top: auto;
}

.footer-content p {
  margin: 0.5rem 0;
  color: #6b7280;
  font-size: 1rem;
}

.footer-content p:first-child {
  font-size: 1.2rem;
  font-weight: 600;
  color: #4f46e5;
}

/* Mobile Styles */
@media (max-width: 768px) {
  .main-nav {
    padding: 1rem;
  }
  
  .logo h1 {
    font-size: 1.5rem;
  }
  
  .mobile-menu-btn {
    display: flex;
  }
  
  .nav-links {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(15px);
    flex-direction: column;
    padding: 6rem 2rem 2rem;
    gap: 1.5rem;
    transform: translateY(-100%);
    transition: transform 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  }
  
  .nav-links.active {
    transform: translateY(0);
  }
  
  .nav-links a {
    font-size: 1.2rem;
    padding: 1rem 2rem;
    width: 100%;
    text-align: center;
  }
  
  main {
    padding: 1rem;
  }
  
  .main-footer {
    padding: 1.5rem 1rem;
  }
  
  .footer-content p {
    font-size: 0.9rem;
  }
}

/* Extra small devices */
@media (max-width: 480px) {
  .main-nav {
    padding: 0.8rem;
  }
  
  .logo h1 {
    font-size: 1.3rem;
  }
  
  .nav-links a {
    font-size: 1.1rem;
    padding: 0.8rem 1.5rem;
  }
  
  main {
    padding: 0.5rem;
  }
}
</style>
