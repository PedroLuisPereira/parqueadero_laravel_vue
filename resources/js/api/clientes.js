import axios from 'axios';

export default {
    all() {
        return axios.get('/api/clientes');
    },
    listar() {
        return axios.get('/api/clientes_listar');
    },
    create(data) {
        return axios.post(`/api/clientes`, data);
    },
    find(id) {
        return axios.get(`/api/clientes/${id}`);
    },
    update(id, data) {
        return axios.put(`/api/clientes/${id}`, data);
    },
    delete(id) {
        return axios.delete(`/api/clientes/${id}`);
    },
};