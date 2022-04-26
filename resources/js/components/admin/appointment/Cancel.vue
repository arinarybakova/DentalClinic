<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <toast
      type="error"
      :msg="errorToast.message"
      :show="errorToast.show"
      @toastClosed="errorToast.show = false"
    ></toast>
    <b-modal
      :id="id"
      title="Tikrai norite atšaukti šį vizitą?"
      centered
      hide-footer
    >
      <b-form @submit="onSubmit">
        <b-form-group
          id="patient-group"
          label="Pacientas"
          label-for="patient-input"
        >
          <b-form-input
            id="patient-input"
            v-model="appointment.patient"
            type="text"
            placeholder="Pacientas"
            disabled
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="dentist-group"
          label="Gyd. odontologas"
          label-for="dentist-input"
        >
          <b-form-input
            id="dentist-input"
            v-model="appointment.dentist"
            type="text"
            placeholder="Gyd. odontologas"
            disabled
          ></b-form-input>
        </b-form-group>

        <b-form-group id="date-group" label="Data" label-for="date-input">
          <b-form-input
            id="date-input"
            v-model="appointment.date"
            type="text"
            placeholder="Data"
            disabled
          ></b-form-input>
        </b-form-group>

        <b-form-group id="time-group" label="Laikas" label-for="time-input">
          <b-form-input
            id="time-input"
            v-model="appointment.time"
            type="text"
            placeholder="Laikas"
            disabled
          ></b-form-input>
        </b-form-group>

        <b-button type="submit" variant="secondary" class="mt-3">
          Taip
        </b-button>
      </b-form>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: {
    id: { required: true },
    appointment: { required: false },
  },
  data() {
    return {
      errorToast: {
        message: "",
        show: false,
      },
    };
  },
  methods: {
    onSubmit(event) {
      event.preventDefault();
      this.axios
        .post("/api/appointments/cancel/" + this.appointment.id)
        .then((response) => {
          if (response.data.success) {
            this.$emit("appointmentCancelled");
            this.$bvModal.hide(this.id);
          } else {
            this.errorToast.message =
              "Atsprašome įvyko klaida, nepavyko atšaukti vizito";
            this.errorToast.show = true;
          }
        });
    },
  },
};
</script>