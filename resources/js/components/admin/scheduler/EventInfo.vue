<template>
  <div>
    <b-modal id="info-event" :title="info.patient" centered hide-footer>
        <b-form-group
          id="patient-group"
          label="Pacientas"
          label-for="patient-input"
        >
          <b-form-input
            id="patient-input"
            v-model="info.patient"
            type="text"
            disabled
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="doctor-group"
          label="Gyd. odontologas"
          label-for="doctor-input"
        >
          <b-form-input
            id="doctor-input"
            v-model="info.dentist"
            type="text"
            disabled
          ></b-form-input>
        </b-form-group>

        <b-form-group id="date-group" label="Data:" label-for="date-input">
          <b-form-input
            id="date-input"
            v-model="info.date"
            type="text"
            placeholder="Data"
            disabled
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="time-from-group"
          label="Laikas nuo:"
          label-for="time-from-input"
        >
          <b-form-input
            id="time-from-input"
            v-model="info.timeFrom"
            type="text"
            placeholder="Laikas nuo"
            disabled
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="time-to-group"
          label="Laikas iki:"
          label-for="time-to-input"
        >
          <b-form-input
            id="time-to-input"
            v-model="info.timeTo"
            type="text"
            placeholder="Laikas iki"
            disabled
          ></b-form-input>
        </b-form-group>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: {
    event: { required: false },
  },
  data() {
    return {
      info: {
        title: "",
        fk_dentist: "",
        date: "",
        timeFrom: "",
        timeTo: "",
      },
      doctorOptions: [],
      doctorNames: [],
    };
  },
  methods: {
    mapEventToInfo() {
      var dateFrom = new Date(this.event.start);
      var dateFormatted =
        dateFrom.getFullYear() +
        "-" +
        this.addPadStart(dateFrom.getMonth() + 1) +
        "-" +
        this.addPadStart(dateFrom.getDate());
      var dateTo = new Date(this.event.end);
      var id = false;
      if (this.event.id) {
        id = this.event.id;
      }
      this.info = {
        id: id,
        dentist: this.event.dentist,
        patient: this.event.patient,
        date: dateFormatted,
        timeFrom:
          this.addPadStart(dateFrom.getHours()) +
          ":" +
          this.addPadStart(dateFrom.getMinutes()),
        timeTo:
          this.addPadStart(dateTo.getHours()) +
          ":" +
          this.addPadStart(dateTo.getMinutes()),
      };
      console.log(this.event);
    },
    addPadStart(value) {
      return value.toString().padStart(2, "0");
    },
  },
  watch: {
    event: function (newVal) {
      this.mapEventToInfo();
    },
  },
};
</script>