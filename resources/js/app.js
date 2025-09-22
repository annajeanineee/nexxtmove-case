import { createApp } from 'vue'
import { createPinia } from 'pinia'
import './bootstrap.js'
import '../css/app.css'
import IndexPage from "./pages/IndexPage.vue";

const app = createApp(IndexPage)
app.use(createPinia())
app.mount('#app')
