<template>
  <div class="card-body">
    <add-user @userAdded="userAdded" v-if="usertype == 3"></add-user>
    <edit-user @userUpdated="userUpdated" :user="selectedUser"></edit-user>
    <delete-user @userDeleted="userDeleted" :user="selectedUser"></delete-user>
    <treatment-admin-modal id="treatment-modal" :patientId="selectedUser.id" v-if="!isDentist"/>
    <treatment-dentist-modal id="treatment-modal" :patientId="selectedUser.id" v-if="isDentist"/>
    
    <toast
      type="success"
      :msg="success.message"
      :show="success.show"
      @toastClosed="success.show = false"
    ></toast>
    <div class="search">
      <b-form-input
        v-model="filter"
        placeholder="Įveskite paieškos raktažodį"
      ></b-form-input>
      <b-button v-on:click="filterTable()">Ieškoti</b-button>
      <b-button v-on:click="clearTable()">Išvalyti</b-button>
    </div>
    <div v-if="v$.filter.$error" class="text-danger mt-1">
      Prašome įvesti paieškos raktažodį
    </div>

    <b-table hover :items="items" :fields="fields" :perPage="0">
      <template #cell(id)="data">
        <b>{{ getUsersId(data.value) }}</b>
      </template>
      <template #cell(created_at)="data">
        {{ getDate(data.value) }}
      </template>
      <template #cell(actions)="data">
        <div class="buttons">
          <b-button v-if="usertype == 2"
            v-on:click="showTreatment(data.item)"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title="Gydymo planas"
            ><i class="fas fa-list"></i
          ></b-button>
          <b-button
            v-on:click="updateUser(data.item)"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title="Redaguoti naudotoją"
            v-if="!isDentist"
            ><i class="fas fa-pencil-alt"></i
          ></b-button>
          <b-button
            v-on:click="deleteUser(data.item)"
            variant="outline-info"
            size="sm"
            v-b-tooltip.hover
            title="Ištrinti naudotoją"
            v-if="!isDentist"
            ><i class="fas fa-trash"></i
          ></b-button>
        </div>
      </template>
    </b-table>
    <b-pagination
      :total-rows="totalRows"
      :per-page="perPage"
      v-model="currentPage"
      v-if="totalRows / perPage > 1"
    />
  </div>
</template>
<script>
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
  props: {
    usertype: { required: true },
  },
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  data() {
    return {
      currentPage: 1,
      perPage: 10,
      totalRows: 1,
      filter: "",
      success: {
        message: "",
        show: false,
      },
      selectedUser: {
        id: "",
        firstname: "",
        lastname: "",
        email: "",
        phone: "",
        created_at: "",
      },
      fields: [
        {
          key: "id",
          label: "ID",
          sortable: true,
        },
        {
          key: "firstname",
          label: "Vardas",
          sortable: true,
        },
        {
          key: "lastname",
          label: "Pavardė",
          sortable: true,
        },
        {
          key: "email",
          label: "El. paštas",
          sortable: true,
        },
        {
          key: "phone",
          label: "Tel. nr.",
          sortable: false,
        },
        {
          key: "created_at",
          label: "Registracija",
          sortable: true,
        },
        {
          key: "actions",
          label: "",
          sortable: false,
        },
      ],
      items: [],
      isDentist: false,
    };
  },
  validations() {
    return {
      filter: { required },
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      var requestParams = {
        page: this.currentPage,
        limit: this.perPage,
        usertype: this.usertype,
      };
      if (this.filter !== "") {
        requestParams = Object.assign(requestParams, { filter: this.filter });
      }
      this.axios
        .get("/api/users", { params: requestParams })
        .then((response) => {
          this.items = response.data.users;
          this.totalRows = response.data.total;
          this.isDentist = response.data.isDentist;
        });
    },
    filterTable() {
      if (this.v$.$validate() && !this.v$.filter.$error) {
        this.fetchUsers();
      }
    },
    clearTable() {
      this.filter = "";
      this.v$.filter.$reset();
      this.fetchUsers();
    },
    getUsersId(value) {
      switch (this.usertype) {
        case "3":
          return "G" + value.toString().padStart(3, "0");
        default:
          return "P" + value.toString().padStart(3, "0");
      }
    },
    getDate(value) {
      var arr = value.split("T");
      if (typeof arr[0] !== "undefined") {
        return arr[0];
      } else {
        return "-";
      }
    },
    deleteUser(user) {
      this.selectedUser = user;
      this.$bvModal.show("delete-user");
    },
    showTreatment(user){
      this.selectedUser = user;
      this.$bvModal.show("treatment-modal");
    },
    updateUser(user) {
      this.selectedUser = user;
      this.$bvModal.show("edit-user");
    },
    userUpdated(user) {
      this.filter = "";
      this.currentPage = 1;
      this.success.message =
        'Naudotojo "' + user.firstname + '" redagavimas sėkmingas';
      this.success.show = true;
      this.fetchUsers();
    },
    userAdded(user) {
      this.filter = "";
      this.currentPage = 1;
      this.success.message =
        'Gyd. odontologas "' +
        user.firstname +
        " " +
        user.lastname +
        '" sėkmingai pridėtas';
      this.success.show = true;
      this.fetchUsers();
    },
    userDeleted() {
      this.filter = "";
      this.currentPage = 1;
      this.success.message = "Naudotojas paskyra ištrinta";
      this.success.show = true;
      this.fetchUsers();
    },
  },
  watch: {
    currentPage: {
      handler: function (value) {
        this.fetchUsers();
      },
    },
  },
};
</script>