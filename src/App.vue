<template>
  <div id="app">
    <header>
      <nav>
        <router-link to="/">Home</router-link> |
        <router-link to="/collection">Collection</router-link> |
        <router-link to="/upload">Upload</router-link> |
        <router-link to="/admin">Admin</router-link>
      </nav>
    </header>
    <main>
      <router-view />
    </main>
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

header {
  background: #f8f9fa;
  padding: 20px;
  border-bottom: 1px solid #dee2e6;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
  margin: 0 10px;
  text-decoration: none;
}

nav a.router-link-exact-active {
  color: #42b983;
}

main {
  padding: 20px;
}

/* Mobile-first styles */
@media (max-width: 600px) {
  nav {
    display: flex;
    flex-direction: column;
  }

  nav a {
    margin: 5px 0;
  }
}
</style>
