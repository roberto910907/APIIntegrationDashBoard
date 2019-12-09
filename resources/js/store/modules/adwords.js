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
                type: 'number',
            },
            {
                field: 'ad_group_id',
                label: 'Ad Group Id',
            },
            {
                field: 'campaign_id',
                label: 'Campaign Id',
            },
            {
                field: 'creative_id',
                label: 'Creative Id',
            },
            {
                field: 'clicks',
                label: 'Clicks',
            },
            {
                field: 'impressions',
                label: 'Impressions',
            },
            {
                field: 'cost',
                label: 'Cost',
            },
        ],
        pagination: {
            enabled: true,
            perPage: 13,
            perPageDropdown: [10, 13, 15, 20],
        },
        sort: {
            enabled: true,
            initialSortBy: {field: 'id', type: 'asc'},
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
        if (state.adwordsSearchId !== '') {
            try {
                const response = await AdwordsApi.getAdwordsList(state.adwordsSearchId);
                
                commit(FETCH_ADWORDS_SUCCESS, response.data);
            } catch (error) {
                commit(FETCH_ADWORDS_ERROR, error);
            }
        }
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
