<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <event-form
      :bus="bus"
      :id="formId"
      title="Redaguoti rezervaciją"
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
    onSubmit(form) {
      console.log(form);
    },
  },
};
</script>