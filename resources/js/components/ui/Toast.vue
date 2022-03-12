<template></template>
<script>
const Toast = Vue.swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 5000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Vue.swal.stopTimer);
    toast.addEventListener("mouseleave", Vue.swal.resumeTimer);
  },
});

export default {
  props: ["type", "msg", "show"],
  methods: {
    showToast() {
      Toast.fire({
        icon: this.type,
        title: this.msg,
      });
      this.$emit("toastClosed");
    },
  },
  watch: {
    show() {
      this.showToast();
    },
  },
};
</script>