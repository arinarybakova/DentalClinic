<template>
  <div>
    <toast
      type="error"
      :msg="errorToast.message"
      :show="errorToast.show"
      @toastClosed="errorToast.show = false"
    ></toast>
    <toast
      type="success"
      :msg="successToast.message"
      :show="successToast.show"
      @toastClosed="successToast.show = false"
    ></toast>
    <b-modal id="modal-1" title="Keisti paskyros duomenis" centered hide-footer>
      <b-form class="profile" @submit="onSubmit">
        <b-form-group
          class="label"
          id="fieldset-1"
          label="Vardas"
          label-for="input-1"
        >
          <b-form-input
            id="input-1"
            v-model="user.firstname"
            trim
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.user.firstname"></form-error>

        <b-form-group
          class="label"
          id="fieldset-1"
          label="Pavardė"
          label-for="input-2"
        >
          <b-form-input
            id="input-2"
            v-model="user.lastname"
            trim
          ></b-form-input>
        </b-form-group>
        <form-error :validation="v$.user.lastname"></form-error>

        <b-form-group
          class="label"
          id="fieldset-1"
          label="Tel. numeris"
          label-for="input-2"
        >
          <b-form-input id="input-2" v-model="user.phone" trim></b-form-input>
        </b-form-group>
        <form-error :validation="v$.user.phone"></form-error>

        <b-button type="submit" variant="secondary" class="mt-3 profile-submit"
          >Išsaugoti</b-button
        >
      </b-form>
    </b-modal>
  </div>
</template>
<script>
import useVuelidate from "@vuelidate/core";
import { required, maxLength, helpers } from "@vuelidate/validators";
export default {
  props: {
    user: { required: true },
  },
  data() {
    return {
      errorToast: {
        message: "",
        show: false,
      },
      successToast: {
        message: "",
        show: false,
      },
    };
  },
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  validations() {
    return {
      user: {
        firstname: {
          required: helpers.withMessage("Prašome įvesti vardą", required),
          maxLength: helpers.withMessage(
            "Vardas negali būti ilgesnis nei 255 simboliai",
            maxLength(255)
          ),
        },
        lastname: {
          required: helpers.withMessage("Prašome įvesti pavardę", required),
          maxLength: helpers.withMessage(
            "Pavardė negali būti ilgesnė nei 255 simboliai",
            maxLength(255)
          ),
        },
        phone: {
          required: helpers.withMessage(
            "Prašome įvesti telefono numerį",
            required
          ),
        },
      },
    };
  },
  methods: {
    onSubmit(event) {
      event.preventDefault();
      if (this.v$.$validate() && !this.v$.$error) {
        this.axios
          .patch("/api/front/profile/update/" + this.user.id, this.user)
          .then((response) => {
            if (response.data.success) {
              this.$bvModal.hide("modal-1");
              this.successToast.message =
                "Paskyros duomenys sėkmingai išsaugoti";
              this.successToast.show = true;
            } else {
              this.errorToast.message =
                "Atsiprašome įvyko klaida, nepavyko pakeisti paskyros duomenų";
              this.errorToast.show = true;
            }
          });
      }
    },
  },
};
</script>