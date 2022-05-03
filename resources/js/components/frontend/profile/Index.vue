<template>
  <div>
    <section class="services" id="services">
      <h1 class="heading">jūsų <span>paskyra</span></h1>
      <profile-form :user="user"></profile-form>
    </section>
    <div class="profile">
      <b-form-group
        class="label"
        id="fieldset-1"
        label="Vardas"
        label-for="input-1"
      >
        <b-form-input
          readonly
          id="input-1"
          v-model="user.firstname"
          trim
        ></b-form-input>
      </b-form-group>

      <b-form-group
        class="label"
        id="fieldset-1"
        label="Pavardė"
        label-for="input-2"
      >
        <b-form-input
          readonly
          id="input-2"
          v-model="user.lastname"
          trim
        ></b-form-input>
      </b-form-group>

      <b-form-group
        class="label"
        id="fieldset-1"
        label="El. paštas"
        label-for="input-2"
      >
        <b-form-input
          readonly
          id="input-2"
          v-model="user.email"
          trim
        ></b-form-input>
      </b-form-group>

      <b-form-group
        class="label"
        id="fieldset-1"
        label="Tel. numeris"
        label-for="input-2"
      >
        <b-form-input
          readonly
          id="input-2"
          v-model="user.phone"
          trim
        ></b-form-input>
      </b-form-group>
      <b-button v-b-modal.modal-1 class="kbutton">Keisti</b-button>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    user: [],
  }),

  created() {
    this.fetchUser();
  },
  methods: {
    fetchUser() {
      this.axios.get("/api/front/profile").then((response) => {
        this.user = response.data;
      });
    },
  },
};
</script>