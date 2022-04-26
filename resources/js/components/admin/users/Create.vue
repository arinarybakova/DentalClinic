<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <b-button v-b-modal.add-user>Pridėti odontologą</b-button>
    <user-form
      :bus="bus"
      :id="formId"
      title="Pridėti gyd. odontologą"
      submitTitle="Pridėti"
      @formSubmit="onSubmit"
    ></user-form>
  </div>
</template>
<script>
export default {
  data() {
    return {
      bus: new Vue(),
      formId: "add-user",
    };
  },
  methods: {
    onSubmit(form) {
      this.axios.post("/api/users/store", form).then((response) => {
        if (response.data.success) {
          this.$emit("userAdded", response.data.user);
          this.$bvModal.hide(this.formId);
          this.bus.$emit("resetForm");
        } else {
          this.errorToast.message =
            "Atsprašome įvyko klaida, nepavyko pridėti gydytojo";
          this.errorToast.show = true;
        }
      });
    },
  },
};
</script>