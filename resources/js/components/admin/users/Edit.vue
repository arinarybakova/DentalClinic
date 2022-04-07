<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <user-form
      :bus="bus"
      :id="formId"
      title="Redaguoti naudotoją"
      submitTitle="Išsaugoti"
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
      formId: "edit-user",
    };
  },
  methods: {
    onSubmit(form) {
      this.axios
        .patch("/api/users/update/" + this.user.id, form)
        .then((response) => {
          if (response.data.success) {
            this.$emit("userUpdated", response.data.user);
            this.$bvModal.hide(this.formId);
            this.bus.$emit("resetForm");
          } else {
            this.errorToast.message =
              "Atsprašome įvyko klaida, nepavyko atnaujinti naudotojo duomenų";
            this.errorToast.show = true;
          }
        });
    },
  },
};
</script>