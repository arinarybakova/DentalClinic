<template>
     <div class="card-body">
        <section class="services" id="services">
            <h1 class="heading">gydymo <span>planas</span></h1>
        </section>
        <b-table class ="ttable" hover :items="items" :fields="fields" :perPage="0" :cell-class-name="classChecker">
        <template #cell(id)="data">
          <b>{{ getTreatmentId(data.value) }}</b>
        </template>
        <template v-slot:cell(status)="{ item }">
        <span :class="{ 'text-green': item.status == 'Atlikta', 'text-red': item.status == 'Atšaukta',
        'text-grey': item.status == 'Laukiama' }">
        {{ item.status }}
        </span>
        </template>
         </b-table>
        <b-pagination
          :total-rows="totalRows"
          :per-page="perPage"
          v-model="currentPage"
          v-if="totalRows / perPage > 1"
       />
       <div class = "totalcost">
          Preliminari gydymo plano kaina: <div class = "price"> {{ total }} Eur</div>
       </div>
  </div>      
</template>
<script>
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
  setup() {
    return {
      v$: useVuelidate(),
    };
  }, 
  data() {
    return {
      currentPage: 1,
      perPage: 10,
      totalRows: 1,
      filter: "",
      success: {
        message: "",
        show: false,
      },
      fields: [
        {
          key: "id",
          label: "ID",
          sortable: false,
        },
        {
          key: "procedure",
          label: "Procedūra",
          sortable: false,
          thClass: 'Pcolumn'
        },
        {
          key: "cost",
          label: "Kaiana",
          sortable: false,
        },
        {
          key: "status",
          label: "Būsena",
          sortable: false,
        },
      ],
      items: [],
    };
  },
  validations() {
    
  },
  created() {
    this.fetchTreatments();
  }, 
  methods: {
    fetchTreatments() {
      var requestParams = {
        page: this.currentPage,
        limit: this.perPage,
      };
      this.axios
        .get("/api/front/treatments", { params: requestParams })
        .then((response) => {
          this.items = response.data.treatments;
          this.totalRows = response.data.total;
        });
    },
    getTreatmentId(value) {
      return "E" + value.toString().padStart(3, "0");
    },
  },
  computed: {
     total() {
       return this.items.reduce((acc, ele) => {
       return acc + parseFloat(ele.cost);
  }, 0);
     },
  },
  watch: {
    currentPage: {
      handler: function (value) {
        this.fetchTreatments();
      },
    },
  },
};
</script>