import axios from 'axios';

const rest = axios.create({
    baseURL: '/api/',
    timeout: 10000,
    credentials: true,
    crossDomain: true,
    withCredentials: true
});

export default rest;
