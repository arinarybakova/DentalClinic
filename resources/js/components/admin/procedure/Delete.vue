<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <procedure-form
      :bus="bus"
      :id="formId"
      :disabled=true
      title="Ar norite ištrinti šią procedūrą?"
      submitTitle="Taip"
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
      formId: "delete-procedure",
    };
  },
  methods: {
    onSubmit(form) {
      this.axios
        .post("/api/procedures/destroy/" + this.procedure.id)
        .then((response) => {
          if (response.data.success) {
            this.$emit("procedureDeleted");
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