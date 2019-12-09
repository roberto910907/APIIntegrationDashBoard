const FETCH_ADWORDS_SUCCESS = 'FETCH_ADWORDS_SUCCESS';
const FETCH_ADWORDS_ERROR = 'FETCH_ADWORDS_ERROR';

import AdwordsApi from '../../api/adwords';

const state = {
    adwordsList: [],
    adwordsSearchId: '',
    tableOptions: {
        columns: [
            {
                field: 'id',
                label: 'Id',
                sortField: 'Id',
            },
        ],
        pagination: {
            enabled: true,
            perPage: 13,
            perPageDropdown: [10, 13, 15, 20],
        },
        sort: {
            enabled: true,
            initialSortBy: {field: 'username', type: 'asc'},
        },
        search: {
            enabled: true,
            placeholder: 'Filter Data....',
        },
    },
};

const mutations = {
    [FETCH_ADWORDS_SUCCESS](state, adwordsList) {
        state.adwordsList = adwordsList;
    },
    [FETCH_ADWORDS_ERROR](state) {
        state.adwordsList = [];
    },
};

const actions = {
    async getAdwordsList({commit, state}) {
        try {
            console.log(state.adwordsSearchId);
            const response = await AdwordsApi.getAdwordsList(state.adwordsSearchId);
            
            commit(FETCH_ADWORDS_SUCCESS, response.data);
        } catch (error) {
            commit(FETCH_ADWORDS_ERROR, error);
        }
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
