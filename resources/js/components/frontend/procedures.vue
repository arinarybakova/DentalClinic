<template>
  <section class="services" id="services">
    <h1 class="heading">teikiamos <span>procedūros</span></h1>
    <div class="box-container">
      <div class="box" v-for="procedure in items" :key="procedure.id">
        <h3>{{ procedure.title }}</h3>
        <p>{{ procedure.details }}</p>
        <div class="cost">Kaina: {{ procedure.price}} Eur</div>
        <!--<a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span></a>-->
      </div>
    </div>
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
    this.fetchProcedures();
  },
  methods: {
    fetchProcedures() {
      this.axios
        .get("/api/front/procedures")
        .then((response) => {
          this.items = response.data;
        });
    },
  },
};
</script>