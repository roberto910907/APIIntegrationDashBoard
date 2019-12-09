<template>
  <div class="m-15">
    <h1>Adwords Client Information</h1>
    <input type="text" name="search_adwords" v-model="adwordsSearchId" @change="getAdwordsList"/>

    <vue-good-table
        :rows="adwordsList"
        :columns="tableOptions.columns"
        :search-options="tableOptions.search"
        :pagination-options="tableOptions.pagination"
        :line-numbers="true" :sort-options="tableOptions.sort"
        style-class="vgt-table bordered">
      <div slot="emptystate">
        There's no Adwords Data for the Client ID you're searching for.
      </div>
    </vue-good-table>
  </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex';

    export default {
        methods: {
            ...mapActions('adwordsList', ['getAdwordsList']),
        },
        computed: {
            ...mapState('adwordsList', ['adwordsList', 'tableOptions']),
            adwordsSearchId: {
                get: function () {
                    return this.$store.state.adwordsList.adwordsSearchId;
                },
                set: function (newAdwordsSearchId) {
                    this.$store.state.adwordsList.adwordsSearchId = newAdwordsSearchId;
                }
            }
        }
    }
</script>
