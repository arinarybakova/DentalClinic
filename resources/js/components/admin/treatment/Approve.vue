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
      title="Ar etapas tikrai atliktas?"
      centered
      hide-footer
    >
      <b-form @submit="onSubmit">

        <b-button type="submit" variant="secondary" class="stagestatus">
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
    treatment: { required: false },
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
        .post("/api/treatments/approve/" + this.treatment.id)
        .then((response) => {
          if (response.data.success) {
            this.$emit("treatmentApproved");
            this.$bvModal.hide(this.id);
          } else {
            this.errorToast.message =
              "Atsprašome įvyko klaida, nepavyko priskirti atliktos būsenos etapui";
            this.errorToast.show = true;
          }
        });
    },
  },
};
</script>