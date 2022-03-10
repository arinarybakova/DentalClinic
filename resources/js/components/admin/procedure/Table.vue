<template>
  <div class="card-body">
    <div class="search">
      <b-form-input
        v-model="filter"
        placeholder="Įveskite paieškos raktažodį"
      ></b-form-input>
      <b-button v-on:click="filterTable()">Ieškoti</b-button>
    </div>
    <b-table hover :items="items" :fields="fields" :perPage="0"></b-table>
    <b-pagination
      :total-rows="totalRows"
      :per-page="perPage"
      v-model="currentPage"
    />
  </div>
</template>
<script>
export default {
  data() {
    return {
      currentPage: 1,
      perPage: 10,
      totalRows: 1,
      filter: "",
      fields: [
        {
          key: "id",
          label: "ID",
          sortable: true,
        },
        {
          key: "title",
          label: "Pavadinimas",
          sortable: true,
        },
        {
          key: "price",
          label: "Kaina",
          sortable: true,
        },
        {
          key: "details",
          label: "Aprašymas",
          sortable: false,
        },
      ],
      items: [],
    };
  },
  created() {
    this.fetchProcedures();
  },
  methods: {
    fetchProcedures() {
      var requestParams = {
        page: this.currentPage,
        limit: this.perPage,
      };
      console.log(requestParams);
      this.axios
        .get("/api/procedures", { params: requestParams })
        .then((response) => {
          this.items = response.data.procedures;
          this.totalRows = response.data.total;
        });
    },
    filterTable() {
      console.log(this.filter);
    }
  },
  watch: {
    currentPage: {
      handler: function (value) {
        this.fetchProcedures().catch((error) => {
          console.error(error);
        });
      },
    },
  },
};
</script>