import { createRouter, createWebHistory } from 'vue-router';
import HomePage from './components/HomePage.vue';
import BookCollectionPage from './components/BookCollectionPage.vue';
import UploadPage from './components/UploadPage.vue';
import AdminPage from './components/AdminPage.vue';
import BookDetailPage from './components/BookDetailPage.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomePage,
  },
  {
    path: '/collection',
    name: 'Collection',
    component: BookCollectionPage,
  },
  {
    path: '/upload',
    name: 'Upload',
    component: UploadPage,
  },
  {
    path: '/admin',
    name: 'Admin',
    component: AdminPage,
  },
  {
    path: '/book/:id',
    name: 'BookDetail',
    component: BookDetailPage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
