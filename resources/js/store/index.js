import Vue from 'vue';
import Vuex from 'vuex';
import AdwordsList from './modules/adwords';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        adwordsList: AdwordsList,
    }
});
