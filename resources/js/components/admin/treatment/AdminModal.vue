<template>
  <div class="w-100 mb-3 d-flex justify-content-end">
    <b-modal size="lg" :id="id" :title="modalTitle" centered hide-footer>
      <b-table class="ttable" hover :items="items" :fields="fields" perPage="0">
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
        <span class="price">{{ total }} Eur</span>
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
      perPage: 10,
      totalRows: 0,
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
  computed: {
    total() {
      var total = this.items.reduce((acc, ele) => {
        if (ele.fk_status != 3) {
          return acc + parseFloat(ele.price);
        } else {
          return acc + parseFloat(0);
        }
      }, 0);

      return total.toFixed(2);
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
  },
};
</script>