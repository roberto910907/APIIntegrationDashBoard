import axios from 'axios';

export default {
    getAdwordsList(adwordsClientId) {
        return axios.get(`/api/v1/adwords_data/${adwordsClientId}`);
    }
}
