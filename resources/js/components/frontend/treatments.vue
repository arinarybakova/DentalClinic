<template>
     <div class="card-body">
        <section class="services" id="services">
            <h1 class="heading">gydymo <span>planas</span></h1>
        </section>
        <div class="searcht">
          <b-form-input
              v-model="filter"
              placeholder="Įveskite paieškos raktažodį"
          ></b-form-input>
          <b-button v-on:click="filterTable()">Ieškoti</b-button>
          <b-button v-on:click="resetTable()">Išvalyti</b-button>
          </div>
          <div v-if="v$.filter.$error" class="text-danger mt-1">
          Prašome įvesti paieškos raktažodį
          </div>
       
        <b-table class ="ttable" hover :items="items" :fields="fields" :perPage="0">
        <template #cell(id)="data">
          <b>{{ getTreatmentId(data.value) }}</b>
        </template>
        <template v-slot:cell(status)="{ item }">
        <span :class="{ 'text-greenp': item.status == 'Atlikta', 'text-redp': item.status == 'Atšaukta',
        'text-greyp': item.status == 'Laukiama' }">
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
       
          Preliminari gydymo plano kaina: <div class = "price">{{ total }} Eur</div>
           <b-button  class = "info"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title='Į gydymo plano preliminarią kainą neįtraukiami etapai, kurių būsena yra "Atšaukta"'
            ><i class="fas fa-info"></i
          ></b-button>
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
          sortable: true,
        },
        {
          key: "title",
          label: "Procedūra",
          sortable: true,
          thClass: 'Pcolumn'
        },
        {
          key: "price",
          label: "Kaina",
          sortable: true,
        },
        {
          key: "status",
          label: "Būsena",
          sortable: true,
        },
      ],
      items: [],
    };
  },
  validations() {
    return {
      filter: { required },
    };
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
    filterTable() {
      if (this.v$.$validate() && !this.v$.filter.$error) {
        this.fetchTreatments();
      }
    },
  },
  computed: {
     total() {
      var total = this.items.reduce((acc, ele) => {
        if (ele.fk_status != 3) {
          return acc + parseFloat(ele.price);
        } else {
          return acc + parseFloat(0);
        }
      }, 0);

      return total.toFixed(2);
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