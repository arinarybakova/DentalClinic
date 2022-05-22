<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <b-modal size="lg" :id="id" :title="modalTitle" centered hide-footer>
      <b-table
        class="ttable"
        hover
        :items="items"
        :fields="fields"
        :no-local-sorting="noLocalSorting"
        @sort-changed="sort"
      >
        <template #cell(id)="data">
          <b>{{ getTreatmentId(data.value) }}</b>
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
      <b-pagination
        :total-rows="totalRows"
        :per-page="perPage"
        v-model="currentPage"
        v-if="totalRows / perPage > 1"
      />
      <div class="totalcost">
        Preliminari gydymo plano kaina:
        <span class="price">{{ totalPrice }} Eur</span>
      </div>
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
      perPage: 5,
      totalRows: 0,
      noLocalSorting: true,
      sortBy: "id",
      sortDesc: true,
      totalPrice: 0,
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
    currentPage: {
      handler: function (value) {
        this.fetchTreatments();
      },
    },
  },
  created() {
    this.fetchTreatments();
  },
  methods: {
    fetchTreatments() {
      var requestParams = {
        page: this.currentPage,
        limit: this.perPage,
        patient: this.patientId,
        sortBy: this.sortBy,
        sortDesc: this.sortDesc,
      };
      this.axios
        .get("/api/treatments", { params: requestParams })
        .then((response) => {
          this.items = response.data.treatments;
          this.totalRows = response.data.total;
          this.totalPrice = response.data.totalPrice;
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
    sort(ctx) {
      this.currentPage = 1;
      this.sortBy = ctx.sortBy;
      this.sortDesc = ctx.sortDesc;
      this.fetchTreatments();
    },
  },
};
</script>