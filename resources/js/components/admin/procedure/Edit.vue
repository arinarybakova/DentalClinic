<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <procedure-form
      :bus="bus"
      :id="formId"
      title="Redaguoti procedūrą"
      submitTitle="Išsaugoti"
      :procedure="procedure"
      @formSubmit="onSubmit"
    ></procedure-form>
  </div>
</template>
<script>
export default {
  props: ["procedure"],
  data() {
    return {
      bus: new Vue(),
      formId: "edit-procedure",
    };
  },
  methods: {
    onSubmit(form) {
      this.axios
        .patch("/api/procedures/update/" + this.procedure.id, form)
        .then((response) => {
          if (response.data.success) {
            this.$emit("procedureUpdated", response.data.procedure);
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