<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <user-form
      :bus="bus"
      :id="formId"
      :disabled=true
      title="Tikrai norite atšaukti šį vizitą?"
      submitTitle="Taip"
      :user="user"
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
      formId: "cancel-appointment",
    };
  },
  methods: {
    onSubmit(form) {
      this.axios
        .post("/api/appointments/cancel/" + this.appointment.id)
        .then((response) => {
          if (response.data.success) {
            this.$emit("appointmentCanceled");
            this.$bvModal.hide(this.formId);
            this.bus.$emit("resetForm");
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