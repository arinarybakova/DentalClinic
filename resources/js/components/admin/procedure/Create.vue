<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <procedure-form :bus="bus" @formSubmit="onSubmit"></procedure-form>
  </div>
</template>
<script>
export default {
  data() {
    return {
        bus: new Vue(),
    };
  },
  methods: {
    onSubmit(form) {
      this.axios.post("/api/procedures/store", form).then((response) => {
        if (response.data.success) {
          this.$emit("procedureAdded", response.data.procedure);
          this.$bvModal.hide("add-procedure");
          this.bus.$emit('resetForm')
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