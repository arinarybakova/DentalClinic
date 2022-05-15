<template>
  <div class="card-body">
    <add-procedure @procedureAdded="procedureAdded" v-if="!isDentist"></add-procedure>
    <edit-procedure
      @procedureUpdated="procedureUpdated"
      :procedure="selectedProcedure"
       v-if="!isDentist"
    ></edit-procedure>
    <delete-procedure
      @procedureDeleted="procedureDeleted"
      :procedure="selectedProcedure"
       v-if="!isDentist"
    ></delete-procedure>
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
      <b-button v-on:click="clearTable()">Išvalyti</b-button>
    </div>
    <div v-if="v$.filter.$error" class="text-danger mt-1">
      Prašome įvesti paieškos raktažodį
    </div>

    <b-table hover :items="items" :fields="fields" :perPage="0">
      <template #cell(id)="data">
        <b>{{ getPatientId(data.value) }}</b>
      </template>
      <template #cell(actions)="data">
        <div class="buttons" v-if="!isDentist">
          <b-button
            v-on:click="updateProcedure(data.item)"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title="Redaguoti procedūrą"
            ><i class="fas fa-pencil-alt"></i
          ></b-button>
          <b-button
            v-on:click="deleteProcedure(data.item)"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title="Ištrinti procedūrą"
            ><i class="fas fa-trash"></i
          ></b-button>
        </div>
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
      selectedProcedure: {
        id: "",
        title: "",
        price: "",
        details: "",
      },
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
          thClass: 'Pdesc'
        },
        {
          key: "actions",
          label: "",
          sortable: false,
        },
      ],
      items: [],
      isDentist: false,
    };
  },
  validations() {
    return {
      filter: { required },
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
      if (this.filter !== "") {
        requestParams = Object.assign(requestParams, { filter: this.filter });
      }
      this.axios
        .get("/api/procedures", { params: requestParams })
        .then((response) => {
          this.items = response.data.procedures;
          this.totalRows = response.data.total;
          this.isDentist = response.data.isDentist;
        });
    },
    filterTable() {
      if (this.v$.$validate() && !this.v$.filter.$error) {
        this.fetchProcedures();
      }
    },
    clearTable() {
      this.filter = "";
      this.v$.filter.$reset();
      this.fetchProcedures();
    },
    getPatientId(value) {
      return "PR" + value.toString().padStart(3, "0");
    },
    procedureAdded(procedure) {
      this.filter = "";
      this.currentPage = 1;
      this.success.message =
        'Procedūra "' + procedure.title + '" sėkmingai pridėta';
      this.success.show = true;
      this.fetchProcedures();
    },
    updateProcedure(procedure) {
      this.selectedProcedure = procedure;
      this.$bvModal.show("edit-procedure");
    },
    deleteProcedure(procedure) {
      this.selectedProcedure = procedure;
      this.$bvModal.show("delete-procedure");
    },
    procedureUpdated(procedure) {
      this.filter = "";
      this.currentPage = 1;
      this.success.message =
        'Procedūros "' + procedure.title + '" redagavimas sėkmingas';
      this.success.show = true;
      this.fetchProcedures();
    },
    procedureDeleted() {
      this.filter = "";
      this.currentPage = 1;
      this.success.message = "Procedūra ištrinta";
      this.success.show = true;
      this.fetchProcedures();
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