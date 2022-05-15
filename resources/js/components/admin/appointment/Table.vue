<template>
  <div class="card-body">
    <approve-appointment
      @appointmentApproved="appointmentApproved"
      :appointment="selectedAppointment"
      id="approve-appointment"
    ></approve-appointment>
    <cancel-appointment
      @appointmentCancelled="appointmentCancelled"
      :appointment="selectedAppointment"
      id="cancel-appointment"
    ></cancel-appointment>
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

    <b-table class="atable" hover :items="items" :fields="fields" :perPage="0">
      <template #cell(id)="data">
        <b>{{ getAppointmentId(data.value) }}</b>
      </template>
      <template #cell(actions)="data">
        <div v-if="!isDentist" class="appointment_buttons">
          <b-button
            :disabled="data.item.fk_status == 2"
            v-on:click="approveAppointment(data.item)"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title="Patvirtinti vizitą"
            class="approve_appointment"
            ><i class="fas fa-check"></i
          ></b-button>
          <b-button
            :disabled="data.item.fk_status == 3"
            v-on:click="cancelAppointment(data.item)"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title="Atšaukti vizitą"
            class="cancel_appointment"
            ><i class="fa fa-times"></i
          ></b-button>
        </div>
      </template>
      <template v-slot:cell(status)="{ item }">
        <span
          :class="{
            'text-green': item.status == 'Patvirtinta',
            'text-red': item.status == 'Atšaukta',
            'text-grey': item.status == 'Rezervuota',
          }"
        >
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
      selectedAppointment: [],
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
      isDentist: false,
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
          this.isDentist = response.data.isDentist;
        });
    },
    filterTable() {
      if (this.v$.$validate() && !this.v$.filter.$error) {
        this.fetchAppointments();
      }
    },
    clearTable() {
      this.filter = "";
      this.v$.filter.$reset();
      this.fetchAppointments();
    },
    getAppointmentId(value) {
      return "V" + value.toString().padStart(3, "0");
    },
    cancelAppointment(appointment) {
      this.selectedAppointment = appointment;
      this.$bvModal.show("cancel-appointment");
    },
    approveAppointment(appointment) {
      this.selectedAppointment = appointment;
      this.$bvModal.show("approve-appointment");
    },
    appointmentApproved() {
      this.filter = "";
      this.currentPage = 1;
      this.success.message =
        'Vizitas "' +
        this.selectedAppointment.patient +
        ", " +
        this.selectedAppointment.dentist +
        '" patvirtintas sėkmingai';
      this.success.show = true;
      this.fetchAppointments();
    },
    appointmentCancelled(appointment) {
      this.filter = "";
      this.currentPage = 1;
      this.success.message =
        'Vizitas "' +
        this.selectedAppointment.patient +
        ", " +
        this.selectedAppointment.dentist +
        '" atšauktas sėkmingai';
      this.success.show = true;
      this.fetchAppointments();
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