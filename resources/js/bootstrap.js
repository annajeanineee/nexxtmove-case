import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configure base URL for Laravel API
// Uses same-origin by default; adjust if backend runs on different host/port
window.axios.defaults.baseURL = '/api';
