<script setup>
import { RouterView } from 'vue-router'
import { useAccountStore } from '@/stores/AccountStore';
import Navbar from './components/Navbar.vue'
import Login from './components/Login.vue'

const accountStore = useAccountStore();
</script>

<template>
  <div class="min-h-screen">
    <header>
      <Navbar />
    </header>
    <main>
      <div v-if="accountStore.isLoggedIn">
        <RouterView />
      </div>
      <div v-else>
        <Login />
      </div>
    </main>
  </div>
</template>
