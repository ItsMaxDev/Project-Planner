import './style.css';

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { useAccountStore } from './stores/AccountStore';
import App from './App.vue'
import router from './router'

const pinia = createPinia()
const app = createApp(App)

app.use(router)
app.use(pinia)

// Load the user's login state
const accountStore = useAccountStore()
accountStore.load().then(() => {
    app.mount('#app')
}).catch((err) => {
    console.error(err)
    app.mount('#app')
});