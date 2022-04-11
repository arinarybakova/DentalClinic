<template>
    <div>
        <calendar :events="events" @fetchEvents="fetchEvents" @updateEvent="updateEvent"/>
        <edit-event @eventUpdated="eventUpdated" @eventAdded="eventAdded" :event="selectedEvent"></edit-event>
    </div>
</template>

<script>
import 'material-design-icons-iconfont/dist/material-design-icons.css'

export default {
    data: () => ({
        value: '',
        events: [],
        fetchedEvents: [],
        selectedEvent: [],
    }),
    methods: {
        fetchEvents(value) {
            console.log(this.value);
            this.axios
                .get("/api/schedules?start=" + value)
                .then((response) => {
                    this.fetchedEvents = response.data;
                    this.mapEvents();
                });
        },
        mapEvents() {
            var mappedEvents = [];
            for (let i = 0; i < this.fetchedEvents.length; i++) {
                const timed = true;
                var start = this.fetchedEvents[i].time_from * 1000;
                var end = this.fetchedEvents[i].time_to * 1000;
                mappedEvents.push({
                    id: this.fetchedEvents[i].id,
                    name: this.fetchedEvents[i].doctor,
                    color: "#3f51b5",
                    start,
                    end,
                    timed,
                    fk_dentist: this.fetchedEvents[i].fk_dentist,
                })
            }
            this.events = mappedEvents;
        },
        updateEvent(event) {
            this.selectedEvent = event.event;
            this.$bvModal.show("edit-event");
        },
        eventUpdated(event) {
            this.fetchEvents(this.value);
        },
        eventAdded(event) {
            this.fetchEvents(this.value);
        }
    },
}
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
        content: '';
    }
    &:hover::after {
        display: block;
    }
}
</style>