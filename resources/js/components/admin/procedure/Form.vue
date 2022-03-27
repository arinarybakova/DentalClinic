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
          id="title-group"
          label="Pavadinimas:"
          label-for="title-input"
        >
          <b-form-input
            id="title-input"
            v-model="form.title"
            type="text"
            placeholder="Pavadinimas"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.title"></form-error>
        <b-form-group id="price-group" label="Kaina:" label-for="price-input">
          <b-form-input
            id="price-input"
            v-model="form.price"
            type="number"
            step="0.01"
            placeholder="Kaina"
            :disabled="disabled"
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.form.price"></form-error>
        <b-form-group
          id="details-group"
          label="Aprašymas:"
          label-for="details-input"
        >
          <b-form-textarea
            id="details-input"
            v-model="form.details"
            placeholder="Aprašymas"
            rows="3"
            max-rows="6"
            :disabled="disabled"
          ></b-form-textarea>
        </b-form-group>
        <form-error :validation="v$.form.details"></form-error>
        <b-button type="submit" variant="secondary" class="mt-3"
          >{{ submitTitle }}</b-button
        >
      </b-form>
    </b-modal>
  </div>
</template>
<script>
import useVuelidate from "@vuelidate/core";
import {
  required,
  maxLength,
  minValue,
  maxValue,
  helpers,
} from "@vuelidate/validators";

export default {
  props: {
    bus: { required: true },
    id: { required: true },
    title: { required: true },
    submitTitle: { required: true },
    procedure: { required: false },
    disabled: { required: false, default: false }
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
      form: {
        title: "",
        price: "",
        details: "",
      },
      errorToast: {
        message: "",
        show: false,
      },
    };
  },
  validations() {
    return {
      form: {
        title: {
          required: helpers.withMessage(
            "Prašome įvesti procedūros pavadinimą",
            required
          ),
          maxLength: helpers.withMessage(
            "Procedūros pavadinimas negali būti ilgesnis nei 255 simboliai",
            maxLength(255)
          ),
        },
        price: {
          required: helpers.withMessage(
            "Prašome įvesti procedūros kainą",
            required
          ),
          minValue: helpers.withMessage(
            "Procedūros kaina turi būti didesnė už 0",
            minValue(0.01)
          ),
          maxValue: helpers.withMessage(
            "Procedūros kaina turi būti mažesnė nei 100",
            maxValue(99.99)
          ),
        },
        details: {
          required: helpers.withMessage(
            "Prašome įvesti procedūros aprašymą",
            required
          ),
          maxLength: helpers.withMessage(
            "Procedūros aprašymas negali būti ilgesnis nei 511 simbolių",
            maxLength(511)
          ),
        },
      },
    };
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
        title: "",
        price: "",
        details: "",
      };
      this.v$.$reset();
    },
  },
  watch: {
    "procedure": function (newVal) {
       this.form = this.procedure;
    }
  },
};
</script>