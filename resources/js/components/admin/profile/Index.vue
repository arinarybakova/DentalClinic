<template>
<div>
    <b-button v-b-modal.modal-1 class ="kbutton">Keisti</b-button>
    <b-modal id="modal-1" :no-close-on-backdrop="true" title ="Keisti paskyros duomenis"
     ok-only ok-variant="secondary" ok-title="Išsauogti">
      <div class = "profile">
        <b-form-group class = "label"
        id="fieldset-1"
        label ="Vardas"
        label-for="input-1"
        :state="state"
        >
        <b-form-input id="input-1" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        <b-form-group class = "label"
        id="fieldset-1"
        label="Pavardė"
        label-for="input-2"
        :state="state"
        >
        <b-form-input id="input-2" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        <b-form-group class = "label"
        id="fieldset-1"
        label="El. paštas"
        label-for="input-2"
        :state="state">
        <b-form-input  id="input-2" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        <b-form-group class = "label"
        id="fieldset-1"
        label="Tel. numeris"
        label-for="input-2"
        :state="state">
        <b-form-input id="input-2" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        <b-form-group class = "label"
        id="fieldset-1"
        label="Slaptažodis"
        label-for="input-2"
        :state="state">
        <b-form-input id="input-2"  input type = "password" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        <b-form-group class = "label"
        id="fieldset-1"
        label="Pakartokite slaptažodį"
        label-for="input-2"
        :state="state">
        <b-form-input id="input-2" input type = "password" v-model="name" :state="state" trim></b-form-input>
        </b-form-group>
        </div>
    </b-modal>
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
        .get("/api/profile")
        .then((response) => {
          this.items = response.data;
        });
    },
  },
};
</script>