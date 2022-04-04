<template>
  <section class="services" id="services">
    <h1 class="heading">vizitų <span>istorija</span></h1>
  </section>
  
</template>
<script>
export default {
  data() {
    return {
      items: [],
    };
  },
  created() {
    this.fetchAppointments();
  },
  methods: {
    fetchAppointments() {
      this.axios
        .get("/api/front/appointments")
        .then((response) => {
          this.items = response.data;
        });
    },
      filterTable() {
      if (this.v$.$validate() && !this.v$.filter.$error) {
        this.fetchUsers();
      }
    },
  },
};
</script>