<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <event-form
      :bus="bus"
      :id="formId"
      title="Redaguoti darbo grafiką"
      submitTitle="Išsaugoti"
      :event="event"
      @formSubmit="onSubmit"
    ></event-form>
  </div>
</template>
<script>
export default {
  props: ["event"],
  data() {
    return {
      bus: new Vue(),
      formId: "edit-event",
    };
  },
  methods: {
    onSubmit(event) {
      if (event.id) {
        this.updateEvent(event);
      } else {
        this.createEvent(event);
      }
    },
    updateEvent(event) {
      this.axios
        .patch("/api/schedules/update/" + event.id, event)
        .then((response) => {
          if (response.data.success) {
            this.$emit("eventUpdated", response.data.event);
            this.$bvModal.hide(this.formId);
            this.bus.$emit("resetForm");
          } else {
            this.errorToast.message =
              "Atsprašome įvyko klaida, nepavyko redaguoti tvarkaraščio";
            this.errorToast.show = true;
          }
        });
    },
    createEvent(event) {
      this.axios.post("/api/schedules/store", event).then((response) => {
        if (response.data.success) {
          this.$emit("eventAdded", response.data.event);
          this.$bvModal.hide(this.formId);
          this.bus.$emit("resetForm");
        } else {
          this.errorToast.message =
            "Atsprašome įvyko klaida, nepavyko pridėti tvarkaraščio";
          this.errorToast.show = true;
        }
      });
    },
  },
};
</script>