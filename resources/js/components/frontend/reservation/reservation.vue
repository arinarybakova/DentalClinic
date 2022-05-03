<template>
  <div>
    <toast
      type="error"
      :msg="errorToast.message"
      :show="errorToast.show"
      @toastClosed="errorToast.show = false"
    ></toast>
    <toast
      type="success"
      :msg="successToast.message"
      :show="successToast.show"
      @toastClosed="successToast.show = false"
    ></toast>
    <section class="services" id="services">
      <h1 class="heading">Vizito <span>rezervacija</span></h1>
    </section>
    <div class="box-container">
      <toast
        type="error"
        :msg="errorToast.message"
        :show="errorToast.show"
        @toastClosed="errorToast.show = false"
      ></toast>
      <b-form class="bookapp" @submit="onSubmit">
        <b-form-group
          id="doctor-group"
          class="doctors"
          label="Pasirinkite gyd. odontologą:"
          label-for="doctor-input"
        >
          <b-form-select
            id="doctor-input"
            v-model="form.doctor"
            :options="doctorOptions"
            class="form-control"
            v-on:change="fetchAvailableTimes()"
          />
        </b-form-group>
        <form-error :validation="v$.form.doctor"></form-error>
        <div class="row" v-if="form.doctor != ''">
          <div class="col-6">
            <b-button
              variant="outline-info"
              class="booka"
              v-on:click="prev()"
              v-if="minDate < monday"
              >Atgal</b-button
            >
          </div>
          <div class="col-6 text-right">
            <b-button variant="outline-info" class="bookp" v-on:click="next()"
              >Pirmyn</b-button
            >
          </div>
        </div>
        <table
          class="table b-table atable reservation-table my-3"
          v-if="form.doctor != ''"
        >
          <thead>
            <tr>
              <th
                class="days"
                v-for="index in 5"
                :key="index"
                :class="getDisabled(index)"
              >
                {{ dayShortFormat[index] }}
                <div class="date" v-text="getDay(index)"></div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <reservation-day
                v-for="index in 5"
                :key="index"
                :times="times[getDay(index)]"
                :date="getDay(index)"
                v-on:setTime="setTime"
              />
            </tr>
          </tbody>
        </table>
        <div class="resb">
          <b-button
            type="submit"
            variant="secondary"
            class="mt-3"
            v-if="form.doctor != ''"
            >Rezervuoti</b-button
          >
        </div>
      </b-form>
    </div>
  </div>
</template>
<script>
import useVuelidate from "@vuelidate/core";
import { required, minValue, helpers } from "@vuelidate/validators";

export default {
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  data() {
    return {
      form: {
        doctor: "",
        date: "",
        time: "",
      },
      errorToast: {
        message: "",
        show: false,
      },
      successToast: {
        message: "",
        show: false,
      },
      doctorOptions: [],
      monday: "",
      minDate: "",
      times: [],
      dayShortFormat: ["", "P", "A", "T", "K", "Pn"],
    };
  },
  validations() {
    return {
      form: {
        doctor: {
          required: helpers.withMessage(
            "Prašome pasirinkti gyd. odontologą",
            required
          ),
          minValue: helpers.withMessage(
            "Prašome pasirinkti gyd. odontologą",
            minValue(1)
          ),
        },
        date: {
          required: helpers.withMessage(
            "Prašome pasirinkti vizito laiką",
            required
          ),
        },
        time: {
          required: helpers.withMessage(
            "Prašome pasirinkti vizito laiką",
            required
          ),
        },
      },
    };
  },
  created() {
    this.getDate();
    this.fetchAvailableTimes();
    this.fetchDoctors();
    this.minDate = this.monday;
  },
  methods: {
    onSubmit(event) {
      event.preventDefault();
      if (this.v$.$validate() && !this.v$.$error) {
        this.addReservation();
      }
    },
    getDate() {
      var today = new Date();
      var day = today.getDay() || 7;
      if (day !== 1) today.setHours(-24 * (day - 1));
      this.monday = today;
    },
    getDay(day) {
      var d = new Date();
      d.setMonth(this.monday.getMonth());
      d.setDate(this.monday.getDate() + day - 1);
      return this.formatDate(d);
    },
    getDisabled(day) {
      var d = new Date();
      d.setMonth(this.monday.getMonth());
      d.setDate(this.monday.getDate() + day - 1);
      return d < new Date() ? "disabled" : "";
    },
    getTimes(day) {
      var d = new Date();
      d.setMonth(this.monday.getMonth());
      d.setDate(this.monday.getDate() + day - 1);
      if (this.times[this.formatDate(d)] !== "undefined") {
        return this.times[this.formatDate(d)];
      } else {
        return [];
      }
    },
    formatDate(date) {
      return (
        date.getFullYear() +
        "-" +
        (date.getUTCMonth() + 1).toString().padStart(2, "0") +
        "-" +
        date.getDate().toString().padStart(2, "0")
      );
    },
    next() {
      var d = new Date();
      d.setMonth(this.monday.getMonth());
      d.setDate(this.monday.getDate() + 7);
      d.setHours(0);
      d.setMinutes(0);
      d.setSeconds(0);
      this.monday = d;
      this.fetchAvailableTimes();
    },
    prev() {
      var d = new Date();
      d.setMonth(this.monday.getMonth());
      d.setDate(this.monday.getDate() - 7);
      d.setHours(0);
      d.setMinutes(0);
      d.setSeconds(0);
      this.monday = d;
      this.fetchAvailableTimes();
    },
    resetForm() {
      this.form = {
        doctor: "",
      };
      this.v$.$reset();
    },
    fetchDoctors() {
      this.axios.get("/api/front/doctors").then((response) => {
        this.doctorOptions.push({ value: "", text: "Pasirinkite gydytoją" });
        for (var i = 0; i < response.data.length; i++) {
          this.doctorOptions.push({
            value: response.data[i].id,
            text: response.data[i].name,
          });
        }
      });
    },
    fetchAvailableTimes() {
      var url = "/api/front/availableTimes?doctor=" + this.form.doctor;
      url += "&dateFrom=" + this.getDay(1);
      url += "&dateTo=" + this.getDay(5);
      this.axios.get(url).then((response) => {
        this.times = response.data;
      });
    },
    setTime(dateTime) {
      this.form.date = dateTime[0];
      this.form.time = dateTime[1];
    },
    addReservation() {
      this.axios
        .post("/api/front/appointments/store", this.form)
        .then((response) => {
          if (response.data.success) {
            this.successToast.message =
              "Vizito rezervacija sėkminga (" +
              response.data["appointment"].time_from +
              ")";
            this.successToast.show = true;
          } else {
            this.errorToast.message =
              "Atsiprašome įvyko klaida, nepavyko užrezervuoti vizito";
            this.errorToast.show = true;
          }
          this.fetchAvailableTimes();
        });
    },
  },
};
</script>