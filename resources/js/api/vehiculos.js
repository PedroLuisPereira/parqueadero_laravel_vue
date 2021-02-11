import axios from 'axios';

export default {
    all() {
        return axios.get('/api/vehiculos');
    },
    create(data) {
        return axios.post(`/api/vehiculos`, data);
    },
    find(id) {
        return axios.get(`/api/vehiculos/${id}`);
    },
    find_cliente(id) {
        return axios.get(`/api/vehiculos_cliente/${id}`);
    },
    update(id, data) {
        return axios.put(`/api/vehiculos/${id}`, data);
    },
    delete(id) {
        return axios.delete(`/api/vehiculos/${id}`);
    },
};