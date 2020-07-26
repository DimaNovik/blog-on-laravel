import axios from 'axios';

const rest = axios.create({
    baseURL: '/api/',
    timeout: 10000,
    credentials: true,
    crossDomain: true,
    withCredentials: true
});

rest.interceptors.request.use(config => {
    config.headers['X-Requested-With'] = 'XMLHttpRequest';
    config.headers['X-CSRF-TOKEN'] = window.csrf_token;
    return config;
}, err => Promise.reject(err));

export default rest;
