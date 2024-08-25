import axios from 'axios';
window.axios = axios;
const apiToken = import.meta.env.VITE_API_TOKEN;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Authorization'] = `${apiToken}`;


