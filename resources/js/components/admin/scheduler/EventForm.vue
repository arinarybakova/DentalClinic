<template>
  <div>
    <toast
      type="error"
      :msg="errorToast.message"
      :show="errorToast.show"
      @toastClosed="errorToast.show = false"
    ></toast>
    <b-modal :id="id" :title="title" centered hide-footer>
      <b-form @submit="onSubmit">
        <b-form-group id="title-group" label="Pavadinimas:" label-for="title-input">
          <b-form-input
            id="title-input"
            v-model="form.title"
            type="text"
            placeholder="Pavadinimas"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.date"></form-error>
        <b-form-group
          id="doctor-group"
          label="Pasirinkite gyd. odontologą"
          label-for="doctor-input"
        >
          <b-form-select 
            id="doctor-input"
            v-model="form.fk_dentist" 
            :options="doctorOptions" />
        </b-form-group>
        <form-error :validation="v$.form.fk_dentist"></form-error>
        <b-form-group id="date-group" label="Data:" label-for="date-input">
          <b-form-input
            id="date-input"
            v-model="form.date"
            type="text"
            placeholder="Data"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.date"></form-error>
        <b-form-group id="time-from-group" label="Laikas nuo:" label-for="time-from-input">
          <b-form-input
            id="time-from-input"
            v-model="form.timeFrom"
            type="text"
            placeholder="Laikas nuo"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.timeFrom"></form-error>
        <b-form-group id="time-to-group" label="Laikas iki:" label-for="time-to-input">
          <b-form-input
            id="time-to-input"
            v-model="form.timeTo"
            type="text"
            placeholder="Laikas iki"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.timeFrom"></form-error>
        <b-button type="submit" variant="secondary" class="mt-3"
          >{{ submitTitle }}</b-button
        >
      </b-form>
    </b-modal>
  </div>
</template>
<script>
import useVuelidate from "@vuelidate/core";
import {
  required,
  helpers
} from "@vuelidate/validators";

export default {
  props: {
    bus: { required: true },
    id: { required: true },
    title: { required: true },
    submitTitle: { required: true },
    event: { required: false },
    disabled: { required: false, default: false }
  },
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  mounted() {
    this.bus.$on("resetForm", this.resetForm);
  },
  data() {
    return {
      form: {
        title: "",
        fk_dentist: "",
        date: "",
        timeFrom: "",
        timeTo: "",
      },
      errorToast: {
        message: "",
        show: false,
      },
      doctorOptions: [],
    };
  },
  validations() {
    return {
      form: {
        title: {
          required: helpers.withMessage(
            "Prašome įvesti rezervacijos pavadinimą",
            required
          ),
        },
        fk_dentist: {
          required: helpers.withMessage(
            "Prašome pasirinkti gydytoją",
            required
          ),
        },
        date: {
          required: helpers.withMessage(
            "Prašome įvesti rezervacijos datą",
            required
          ),
        },
        timeFrom: {
          required: helpers.withMessage(
            "Prašome pasirinkti laiką nuo",
            required
          ),
        },
        timeTo: {
          required: helpers.withMessage(
            "Prašome pasirinkti laiką iki",
            required
          ),
        },
      },
    };
  },
  created() {
    this.fetchDoctors();
  },
  methods: {
    onSubmit(event) {
      event.preventDefault();
      if (this.v$.$validate() && !this.v$.$error) {
        this.$bvModal.hide(this.formId);
        this.$emit("formSubmit", this.form);
      }
    },
    resetForm() {
      this.form = {
        title: "",
        fk_dentist: "",
        date: "",
        timeFrom: "",
        timeTo: "",
      };
      this.v$.$reset();
    },
    mapEventToForm() {
      console.log(this.event);
      var dateFrom = new Date(this.event.start);
      var dateFormatted = dateFrom.getFullYear() + "-" + this.addPadStart((dateFrom.getMonth() + 1)) + "-" + this.addPadStart(dateFrom.getDate());
      var dateTo = new Date(this.event.end);
      this.form = {
        title: this.event.name,
        fk_dentist: this.event.fk_dentist,
        date: dateFormatted,
        timeFrom: this.addPadStart(dateFrom.getHours()) + ":" + this.addPadStart(dateFrom.getMinutes()),
        timeTo: this.addPadStart(dateTo.getHours()) + ":" + this.addPadStart(dateTo.getMinutes()),
      };
    },
    addPadStart(value) {
      return value.toString().padStart(2, "0");
    },
    fetchDoctors() {
          this.axios
            .get("/api/users?usertype=3&page=1")
            .then((response) => {
              this.doctorOptions.push({ value: '', text: 'Pasirinkite gydytoją' });
              for(var i = 0; i < response.data.users.length; i++) {
                this.doctorOptions.push({ value: response.data.users[i].id, text: response.data.users[i].name });
              }
            });
        },
  },
  watch: {
    "event": function (newVal) {
       this.mapEventToForm();
    }
  },
};
</script>