<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <user-form
      :bus="bus"
      :id="formId"
      :disabled=true
      title="Ar norite ištrinti šį gydytoją?"
      submitTitle="Taip"
      :user="user"
      @formSubmit="onSubmit"
    ></user-form>
  </div>
</template>
<script>
export default {
  props: ["user"],
  data() {
    return {
      bus: new Vue(),
      formId: "delete-user",
    };
  },
  methods: {
    onSubmit(form) {
      this.axios
        .post("/api/users/destroy/" + this.user.id)
        .then((response) => {
          if (response.data.success) {
            this.$emit("userDeleted");
            this.$bvModal.hide(this.formId);
            this.bus.$emit("resetForm");
          } else {
            this.errorToast.message =
              "Atsprašome įvyko klaida, nepavyko ištrinti gydytojo";
            this.errorToast.show = true;
          }
        });
    },
  },
};
</script>