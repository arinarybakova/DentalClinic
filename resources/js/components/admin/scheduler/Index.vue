<template>
  <div>
    <b-form>
      <b-form-group
        id="fieldset-filter"
        v-if="!isDentist"
        label-cols-sm="4"
        label-cols-lg="3"
        content-cols-sm
        content-cols-lg="7"
        label="Gydytojas (-ai)"
        label-for="input-doctor-filter"
      >
        <b-form-select
          id="input-doctor-filter"
          v-model="filterDentist"
          v-on:change="filterEvents"
          :options="doctorOptions"
          class="form-select"
        />
      </b-form-group>
      <b-form-checkbox
        id="checkbox-appointments"
        v-model="showAppointments"
        name="checkbox-appointments"
        value="true"
        unchecked-value="false"
        class="mb-3 mx-3"
        v-on:change="filterEvents"
      >
        Rodyti patvirtintus vizitus
      </b-form-checkbox>
    </b-form>
    <calendar
      :events="events"
      :isDentist="isDentist"
      @fetchEvents="fetchEvents"
      @updateEvent="updateEvent"
      @showEventInfo="showEventInfo"
      @valueChange="updateValue"
    />
    <edit-event
      @eventUpdated="eventUpdated"
      @eventAdded="eventAdded"
      :event="selectedEvent"
    ></edit-event>

    <info-event :event="infoEvent" />
  </div>
</template>

<script>
import "material-design-icons-iconfont/dist/material-design-icons.css";

export default {
  data: () => ({
    value: "",
    filterDentist: "",
    events: [],
    selectedEvent: [],
    infoEvent: [],
    doctorOptions: [],
    showAppointments: false,
    isDentist: true,
  }),
  created() {
    this.fetchDoctors();
  },
  methods: {
    fetchEvents(value) {
      this.events = [];
      this.fetchSchedules(value);
      if (this.showAppointments) {
        this.fetchAppointments(value);
      }
    },
    fetchSchedules(value) {
      var url = "/api/schedules?start=" + value;
      if (this.filterDentist !== "") {
        url += "&doctors=" + this.filterDentist;
      }
      this.axios.get(url).then((response) => {
        this.mapEvents(response.data.schedules, "#c6e2e9", "schedule");
        this.isDentist = response.data.isDentist;
      });
    },
    fetchAppointments(value) {
      var url = "/api/appointmentEvents?start=" + value + "&approved=1";
      if (this.filterDentist !== "") {
        url += "&doctors=" + this.filterDentist;
      }
      this.axios.get(url).then((response) => {
        this.mapEvents(response.data, "#a2ebca", "appoinment");
      });
    },
    filterEvents() {
      this.fetchEvents(this.value);
    },
    mapEvents(fetched, color, eventType) {
      for (let i = 0; i < fetched.length; i++) {
        const timed = true;
        var start = fetched[i].time_from * 1000;
        var end = fetched[i].time_to * 1000;
        this.events.push({
          id: fetched[i].id,
          name:
            (fetched[i].patient ? fetched[i].patient + ", " : "") +
            fetched[i].doctor,
          color: color,
          eventType,
          start,
          end,
          timed,
          dentist: fetched[i].doctor,
          fk_dentist: fetched[i].fk_dentist,
          patient: fetched[i].patient ? fetched[i].patient : "",
          fk_patient: fetched[i].fk_patient ? fetched[i].fk_patient : "",
        });
      }
    },
    fetchDoctors() {
      this.axios.get("/api/users?usertype=3&page=1").then((response) => {
        this.doctorOptions.push({ value: "", text: "Visi gydytojai" });
        for (var i = 0; i < response.data.users.length; i++) {
          this.doctorOptions.push({
            value: response.data.users[i].id,
            text: response.data.users[i].name,
          });
        }
      });
    },
    updateEvent(event) {
      this.selectedEvent = event.event;
      this.$bvModal.show("edit-event");
    },
    showEventInfo(event) {
      this.infoEvent = event.event;
      this.$bvModal.show("info-event");
    },
    eventUpdated(event) {
      this.fetchEvents(this.value);
    },
    eventAdded(event) {
      this.fetchEvents(this.value);
    },
    updateValue(value) {
      this.value = value;
    },
  },
};
</script>

<style scoped lang="scss">
.v-event-draggable {
  padding-left: 6px;
}

.v-event-timed {
  user-select: none;
  -webkit-user-select: none;
}

.v-event-drag-bottom {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 4px;
  height: 4px;
  cursor: ns-resize;
  &::after {
    display: none;
    position: absolute;
    left: 50%;
    height: 4px;
    border-top: 1px solid white;
    border-bottom: 1px solid white;
    width: 16px;
    margin-left: -8px;
    opacity: 0.8;
    content: "";
  }
  &:hover::after {
    display: block;
  }
}
</style>