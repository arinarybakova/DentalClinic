<template>
  <div>
    <toast
      type="error"
      :msg="errorToast.message"
      :show="errorToast.show"
      @toastClosed="errorToast.show = false"
    ></toast>
    <b-modal :id="id" :title="title" centered hide-footer>
      <b-form @submit="onSubmit">
        <b-form-group
          id="firstname-group"
          label="Vardas:"
          label-for="firstname-input"
        >
          <b-form-input
            id="firstname-input"
            v-model="form.firstname"
            type="text"
            placeholder="Vardas"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.firstname"></form-error>
        <b-form-group
          id="lastname-group"
          label="Pavardė:"
          label-for="lastname-input"
        >
          <b-form-input
            id="lastname-input"
            v-model="form.lastname"
            type="text"
            placeholder="Pavardė"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.lastname"></form-error>
        <b-form-group
          id="email-group"
          label="El. paštas:"
          label-for="email-input"
        >
          <b-form-input
            id="email-input"
            v-model="form.email"
            type="email"
            placeholder="El. paštas:"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.email"></form-error>
        <b-form-group
          id="phone-group"
          label="Tel. numeris:"
          label-for="phone-input"
        >
          <b-form-input
            id="phone-input"
            v-model="form.phone"
            type="text"
            placeholder="Tel. numeris"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.phone"></form-error>
        <b-button type="submit" variant="secondary" class="mt-3">{{
          submitTitle
        }}</b-button>
      </b-form>
    </b-modal>
  </div>
</template>
<script>
import useVuelidate from "@vuelidate/core";
import {
  required,
  maxLength,
  email,
  helpers,
} from "@vuelidate/validators";

export default {
  props: {
    bus: { required: true },
    id: { required: true },
    title: { required: true },
    submitTitle: { required: true },
    user: { required: false },
    disabled: { required: false, default: false },
  },
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  mounted() {
    this.bus.$on("resetForm", this.resetForm);
  },
  data() {
    return {
      form: {},
      errorToast: {
        message: "",
        show: false,
      },
    };
  },
  validations() {
    return {
      form: {
        firstname: {
          required: helpers.withMessage(
            "Prašome įvesti naudotojo vardą",
            required
          ),
          maxLength: helpers.withMessage(
            "Naudotojo vardas negali būti ilgesnis nei 255 simboliai",
            maxLength(255)
          ),
        },
        lastname: {
          required: helpers.withMessage(
            "Prašome įvesti naudotojo pavardę",
            required
          ),
          maxLength: helpers.withMessage(
            "Naudotojo pavardė negali būti ilgesnė nei 255 simboliai",
            maxLength(255)
          ),
        },
        email: {
          required: helpers.withMessage(
            "Prašome įvesti naudotojo el. paštą",
            required
          ),
          email: helpers.withMessage(
            "Naudotojo el. paštas neatitinka formato",
            email
          )
        },
        phone: {
          required: helpers.withMessage(
            "Prašome įvesti naudotojo tel. numerį",
            required
          ),
          maxLength: helpers.withMessage(
            "Naudotojo tel. numeris negali būti ilgesnis nei 255 simboliai",
            maxLength(255)
          ),
        },
      },
    };
  },
  mounted() {
    this.resetForm();
  },
  methods: {
    onSubmit(event) {
      event.preventDefault();
      if (this.v$.$validate() && !this.v$.$error) {
        this.$emit("formSubmit", this.form);
      }
    },
    resetForm() {
      this.form = {
        id: "",
        firstname: "",
        lastname: "",
        email: "",
        phone: "",
        created_at: ""
      };
      this.v$.$reset();
    },
  },
  watch: {
    user: function (newVal) {
      this.form = this.user;
    },
  },
};
</script>