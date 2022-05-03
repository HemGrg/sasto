import axios from "axios";
axios.defaults.baseURL = 'https://b2badmin.webhouse.com.np/';
console.log('setting authorization header');
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');

export default axios;