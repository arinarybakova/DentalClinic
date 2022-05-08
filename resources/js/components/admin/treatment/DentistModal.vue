<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <toast
      type="error"
      :msg="errorToast.message"
      :show="errorToast.show"
      @toastClosed="errorToast.show = false"
    ></toast>
    <b-modal :id="id" :title="modalTitle" centered hide-footer>
      <b-button v-on:click="addRow()" class="mb-3">Pridėti etapą</b-button>
      <b-form @submit="submit">
        <b-table
          class="ttable"
          hover
          :items="items"
          :fields="fields"
          perPage="0"
        >
          <template #cell(id)="data">
            <b>{{ getTreatmentId(data.value) }}</b>
          </template>
          <template #cell(title)="data">
            <b v-if="!data.item.new">{{ data.value }}</b>
            <b-form-select
              v-else
              v-model="data.item.fk_procedure"
              :options="procedures"
              class="form-select"
            ></b-form-select>
          </template>
          <template #cell(price)="data">
            <span v-if="!data.item.new">{{ data.value }}</span>
            <span v-else>{{ getPrice(data.item.fk_procedure) }}</span>
          </template>
          <template v-slot:cell(status)="{ item }">
            <span
              :class="{
                'text-greenp': item.status == 'Atlikta',
                'text-redp': item.status == 'Atšaukta',
                'text-greyp': item.status == 'Laukiama',
              }"
            >
              {{ item.status }}
            </span>
          </template>
        </b-table>
        <b-button type="submit" variant="secondary" class="mt-3"
          >Išsaugoti</b-button
        >
      </b-form>
      <b-pagination
        :total-rows="totalRows"
        :per-page="perPage"
        v-model="currentPage"
        v-if="totalRows / perPage > 1"
      />
    </b-modal>
  </div>
</template>
<script>
export default {
  props: {
    id: { required: true },
    patientId: { required: true },
  },
  data() {
    return {
      modalTitle: "",
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      procedures: [],
      errorToast: {
        message: "",
        show: false,
      },
      fields: [
        {
          key: "id",
          label: "ID",
          sortable: true,
        },
        {
          key: "title",
          label: "Procedūra",
          sortable: true,
          thClass: "Pcolumn",
        },
        {
          key: "price",
          label: "Kaina",
          sortable: true,
        },
        {
          key: "status",
          label: "Būsena",
          sortable: true,
        },
      ],
      items: [],
    };
  },
  watch: {
    patientId: function () {
      this.fetchTreatments();
      this.modalTitle =
        "Paciento (P" +
        this.patientId.toString().padStart(3, "0") +
        ") gydymo planas";
    },
  },
  created() {
    this.fetchProcedures();
  },
  methods: {
    fetchTreatments() {
      var requestParams = {
        page: this.currentPage,
        limit: this.perPage,
        patient: this.patientId,
      };
      this.axios
        .get("/api/treatments", { params: requestParams })
        .then((response) => {
          this.items = response.data.treatments;
          this.totalRows = response.data.total;
        });
    },
    getTreatmentId(value) {
      return "E" + value.toString().padStart(3, "0");
    },
    filterTable() {
      if (this.v$.$validate() && !this.v$.filter.$error) {
        this.fetchTreatments();
      }
    },
    addRow() {
      this.items.push({
        fk_patient: this.patientId,
        fk_procedure: "",
        fk_status: 1,
        status: "Laukiama",
        new: true,
      });
    },
    fetchProcedures() {
      var requestParams = {
        page: 1,
        limit: 100,
      };
      this.axios
        .get("/api/procedures", { params: requestParams })
        .then((response) => {
          this.procedures = [];
          for (var i = 0; i < response.data.procedures.length; i++) {
            this.procedures.push({
              value: response.data.procedures[i].id,
              text: response.data.procedures[i].title,
              price: response.data.procedures[i].price,
            });
          }
        });
    },
    getPrice(id) {
      for (var i = 0; i < this.procedures.length; i++) {
        if (this.procedures[i].value == id) {
          return this.procedures[i].price;
        }
      }
      return "";
    },
    submit(event) {
      event.preventDefault();
      console.log(this.items);
      this.axios.post("/api/treatments/store", this.items).then((response) => {
        this.fetchTreatments();
        if (!response.data.success) {
          this.errorToast.message =
            "Atsprašome įvyko klaida, nepavyko pridėti gydymo plano etapo";
          this.errorToast.show = true;
        }
      });
    },
  },
};
</script>