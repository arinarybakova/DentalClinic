<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <toast
      type="error"
      :msg="errorToast.message"
      :show="errorToast.show"
      @toastClosed="errorToast.show = false"
    ></toast>
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
      errorToast: {
        message: "",
        show: false,
      },
    };
  },
  methods: {
    onSubmit(form) {
      this.axios
        .post("/api/procedures/destroy/" + this.procedure.id)
        .then((response) => {
          if (response.data.success) {
            this.$emit("procedureDeleted");
            this.bus.$emit("resetForm");
          } else {
            if(response.data.errorMsg) {
              this.errorToast.message = response.data.errorMsg;
            } else {
              this.errorToast.message =
                "Atsprašome įvyko klaida, nepavyko pridėti procedūros";
            }
            this.errorToast.show = true;
          }
          this.$bvModal.hide(this.formId);
        });
    },
  },
};
</script>