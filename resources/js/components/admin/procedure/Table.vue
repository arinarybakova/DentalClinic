<template>
  <div class="card-body">
    <div class="search">
      <b-form-input
        v-model="filter"
        placeholder="Įveskite paieškos raktažodį"
      ></b-form-input>
      <b-button v-on:click="filterTable()">Ieškoti</b-button>
    </div>
    <div v-if="v$.filter.$error" class="text-danger mt-1">Prašome įvesti paieškos raktažodį</div>

    <b-table hover :items="items" :fields="fields" :perPage="0">
      <template #cell(id)="data">
        <b>{{ getPatientId(data.value) }}</b>
      </template>
    </b-table>
    <b-pagination
      :total-rows="totalRows"
      :per-page="perPage"
      v-model="currentPage"
    />
  </div>
</template>
<script>
import useVuelidate from '@vuelidate/core'
import { required } from '@vuelidate/validators'

export default {
  setup () {
    return {
      v$: useVuelidate()
    }
  },
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
  validations () {
    return {
      filter: { required }
    }
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
      if(this.filter !== "") {
        requestParams = Object.assign(requestParams, {filter: this.filter});
      }
      console.log(requestParams);
      this.axios
        .get("/api/procedures", { params: requestParams })
        .then((response) => {
          this.items = response.data.procedures;
          this.totalRows = response.data.total;
        });
    },
    filterTable() {
      if (this.v$.$validate() && !this.v$.filter.$error) {
        this.fetchProcedures();
      }
    },
    getPatientId(value) {
      return "P" + value.toString().padStart(3, '0');
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