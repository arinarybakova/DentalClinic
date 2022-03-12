<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <b-button v-b-modal.add-procedure>Pridėti procedūrą</b-button>
    <procedure-form
      :bus="bus"
      :id="formId"
      title="Pridėti procedūrą"
      submitTitle="Pridėti"
      @formSubmit="onSubmit"
    ></procedure-form>
  </div>
</template>
<script>
export default {
  data() {
    return {
      bus: new Vue(),
      formId: "add-procedure",
    };
  },
  methods: {
    onSubmit(form) {
      this.axios.post("/api/procedures/store", form).then((response) => {
        if (response.data.success) {
          this.$emit("procedureAdded", response.data.procedure);
          this.$bvModal.hide(this.formId);
          this.bus.$emit("resetForm");
        } else {
          this.errorToast.message =
            "Atsprašome įvyko klaida, nepavyko pridėti procedūros";
          this.errorToast.show = true;
        }
      });
    },
  },
};
</script>