<template>
     <div class="card-body">
        <div class="search">
        <b-form-input
            v-model="filter"
            placeholder="Įveskite paieškos raktažodį"
        ></b-form-input>
        <b-button v-on:click="filterTable()">Ieškoti</b-button>
        </div>
        <div v-if="v$.filter.$error" class="text-danger mt-1">
        Prašome įvesti paieškos raktažodį
        </div>
       
        <b-table class="atable" hover :items="items" :fields="fields" :perPage="0">
          <template #cell(id)="data">
            <b>{{ getAppointmentId(data.value) }}</b>
          </template>
           <template #cell(actions)="data">
        <div class="buttons">
          <b-button
            v-on:click="updateAppointment(data.item)"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title="Patvirtinti vizitą"
            ><i class="fas fa-check"></i
          ></b-button>
          <b-button
            v-on:click="deleteProcedure(data.item)"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title="Atšaukti vizitą"
            ><i class="fa fa-times"></i
          ></b-button>
        </div>
      </template>
          <template v-slot:cell(status)="{ item }">
          <span :class="{ 'text-green': item.status == 'Patvirtinta', 'text-red': item.status == 'Atšaukta',
          'text-grey': item.status == 'Rezervuota' }">
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
          key: "patient",
          label: "Pacientas",
          sortable: true,
        },
        {
          key: "dentist",
          label: "Gyd. odontologas",
          sortable: true,
        },
        {
          key: "date",
          label: "Data",
          sortable: true,
        },
        {
          key: "time",
          label: "Laikas",
          sortable: true,
        },
        {
          key: "status",
          label: "Būsena",
          sortable: true,
        },
        {
          key: "actions",
          label: "",
          sortable: false,
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
    this.fetchAppointments();
  },
  methods: {
    fetchAppointments() {
      var requestParams = {
        page: this.currentPage,
        limit: this.perPage,
      };
      if (this.filter !== "") {
        requestParams = Object.assign(requestParams, { filter: this.filter });
      }
      this.axios
        .get("/api/appointments", { params: requestParams })
        .then((response) => {
          this.items = response.data.appointments;
          this.totalRows = response.data.total;
        });
    },
    filterTable() {
      if (this.v$.$validate() && !this.v$.filter.$error) {
        this.fetchAppointments();
      }
    },
    getAppointmentId(value) {
      return "V" + value.toString().padStart(3, "0");
    },
  },
  watch: {
    currentPage: {
      handler: function (value) {
        this.fetchAppointments();
      },
    },
  },
};
</script>