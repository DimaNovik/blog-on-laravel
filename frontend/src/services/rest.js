import axios from 'axios';
import Cookies from "js-cookie";

const rest = axios.create({
    baseURL: '/api/',
    timeout: 10000,
    credentials: true,
    crossDomain: true,
    withCredentials: true
});

rest.interceptors.request.use(config => {
    config.headers['Authorization'] = `Bearer ${Cookies.get('access_token')}`;
    return config;
}, err => Promise.reject(err));

export default rest;
