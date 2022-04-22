<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <user-form
      :bus="bus"
      :id="formId"
      :disabled=true
      title="Tikrai norite patvirtinti šį vizitą?"
      submitTitle="Taip"
      :appointment="appointment"
      @formSubmit="onSubmit"
    ></user-form>
  </div>
</template>
<script>
export default {
  props: ["appointment"],
  data() {
    return {
      bus: new Vue(),
      formId: "approve-appointment",
    };
  },
  methods: {
    onSubmit(form) {
      this.axios
        .post("/api/appointments/approve/" + this.appointment.id)
        .then((response) => {
          if (response.data.success) {
            this.$emit("appointmentApproved");
            this.$bvModal.hide(this.formId);
            this.bus.$emit("resetForm");
          } else {
            this.errorToast.message =
              "Atsprašome įvyko klaida, nepavyko patvirtinti vizito";
            this.errorToast.show = true;
          }
        });
    },
  },
};
</script>