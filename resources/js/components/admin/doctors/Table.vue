<template>
  <div class="card-body">
    <toast
      type="success"
      :msg="success.message"
      :show="success.show"
      @toastClosed="success.show = false"
    ></toast>
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

    <b-table hover :items="items" :fields="fields" :perPage="0">
      <template #cell(id)="data">
        <b>{{ getDoctorsId(data.value) }}</b>
      </template>
      <template #cell(created_at)="data">
        {{ getDate(data.value) }}
      </template>
      <template #cell(patients)> 0 </template>
      <template #cell(actions)="data">
        <b-button
          v-on:click="updateDoctor(data.item)"
          variant="outline-info"
          size="sm"
          v-b-tooltip.hover
          title="Redaguoti daktarą"
          ><i class="fas fa-pencil-alt"></i
        ></b-button>
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
          key: "name",
          label: "Vardas Pavardė",
          sortable: true,
        },
        {
          key: "email",
          label: "El. paštas",
          sortable: true,
        },
        {
          key: "phone",
          label: "Tel. nr.",
          sortable: false,
        },
        {
          key: "patients",
          label: "Priskirti pacientai",
          sortable: true,
        },
        {
          key: "created_at",
          label: "Dirba nuo",
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
    this.fetchDoctors();
  },
  methods: {
    fetchDoctors() {
      var requestParams = {
        page: this.currentPage,
        limit: this.perPage,
      };
      if (this.filter !== "") {
        requestParams = Object.assign(requestParams, { filter: this.filter });
      }
      this.axios
        .get("/api/doctors", { params: requestParams })
        .then((response) => {
          this.items = response.data.doctors;
          this.totalRows = response.data.total;
        });
    },
    filterTable() {
      if (this.v$.$validate() && !this.v$.filter.$error) {
        this.fetchProcedures();
      }
    },
    getDoctorsId(value) {
      return "D" + value.toString().padStart(3, "0");
    },
    getDate(value) {
      var arr = value.split("T");
      if (typeof arr[0] !== "undefined") {
        return arr[0];
      } else {
        return "-";
      }
    },
    updateDoctor(procedure) {
      // this.selectedProcedure = procedure;
      // this.$bvModal.show("edit-procedure");
    },
  },
  watch: {
    currentPage: {
      handler: function (value) {
        this.fetchProcedures();
      },
    },
  },
};
</script>