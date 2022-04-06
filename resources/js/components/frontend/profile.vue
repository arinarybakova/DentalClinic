<template>
<div>
  <section class="services" id="services">
    <h1 class="heading">jūsų <span>paskyra</span></h1>
    </section>
    <div class = "profile">
        <b-form-group class = "label"
        id="fieldset-1"
        label ="Vardas"
        label-for="input-1"
        :state="state"
        >
        <b-form-input readonly id="input-1" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        <b-form-group class = "label"
        id="fieldset-1"
        label="Pavardė"
        label-for="input-2"
        :state="state"
        >
        <b-form-input readonly id="input-2" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        <b-form-group class = "label"
        id="fieldset-1"
        label="El. paštas"
        label-for="input-2"
        :state="state">
        <b-form-input readonly id="input-2" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        <b-form-group class = "label"
        id="fieldset-1"
        label="Tel. numeris"
        label-for="input-2"
        :state="state">
        <b-form-input readonly id="input-2" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        <b-form-group class = "label"
        id="fieldset-1"
        label="Slaptažodis"
        label-for="input-2"
        :state="state">
        <b-form-input readonly id="input-2" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
    </div>
     <b-button>Keisti</b-button>
  </div>
</template>
<script>
export default {
  data() {
    return {
      items: [],
    };
  },
  created() {
    this.fetchUser();
  },
  methods: {
    fetchUser() {
      this.axios
        .get("/api/front/profile")
        .then((response) => {
          this.items = response.data;
        });
    },
  },
};
</script>