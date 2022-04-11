<template>
    <v-row data-app>
        <v-col>
            <v-toolbar flat>
                <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">Today</v-btn>
                <v-btn fab text small color="grey darken-2" @click="prev">
                    <v-icon small>
                        mdi-chevron-left
                    </v-icon>
                </v-btn>
                <v-btn fab text small color="grey darken-2" @click="next">
                    <v-icon small>
                        mdi-chevron-right
                    </v-icon>
                </v-btn>
                <v-toolbar-title v-if="$refs.calendar">
                    {{ $refs.calendar.title }}
                </v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-calendar 
                ref="calendar" 
                v-model="value" 
                color="primary" 
                type="week" 
                :events="events" 
                :event-color="getEventColor" 
                :event-ripple="false" 
                :interval-height="intervalHeight" 
                :weekdays="weekdays" 
                @change="fetchEvents" 
                @click:event="updateEvent" 
                @click:more="viewDay"
                @click:date="viewDay" 
                @mousedown:event="startDrag" 
                @mousedown:time="startTime" 
                @mousemove:time="mouseMove" 
                @mouseup:time="endDrag" 
                @mouseleave.native="cancelDrag">

                <template v-slot:event="{ event, timed, eventSummary }">
                    <div class="v-event-draggable" v-html="eventSummary()"></div>
                    <div v-if="timed" class="v-event-drag-bottom" @mousedown.stop="extendBottom(event)"></div>
                </template>

            </v-calendar>
        </v-col>
    </v-row>
</template>

<script>
import 'material-design-icons-iconfont/dist/material-design-icons.css'

export default {
    props: {
        events: { required: true }
    },
    data: () => ({
        value: '',
        dragEvent: null,
        dragStart: null,
        createEvent: null,
        createStart: null,
        extendOriginal: null,
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false,
        intervalHeight: 30,
        weekdays: [1, 2, 3, 4, 5, 6, 0]
    }),
    methods: {
        setToday() {
            this.value = ''
        },
        prev() {
            this.$refs.calendar.prev()
        },
        next() {
            this.$refs.calendar.next()
        },
        startDrag({ event, timed }) {
            if (event && timed) {
                this.dragEvent = event
                this.dragTime = null
                this.extendOriginal = null
            }
        },
        startTime(tms) {
            const mouse = this.toTime(tms)
            if (this.dragEvent && this.dragTime === null) {
                const start = this.dragEvent.start
                this.dragTime = mouse - start
            } else {
                this.createStart = this.roundTime(mouse)
                this.createEvent = {
                    name: `Event #${this.events.length}`,
                    color: '#3f51b5',
                    start: this.createStart,
                    end: this.createStart,
                    timed: true,
                }
                this.events.push(this.createEvent)
            }
        },
        extendBottom(event) {
            this.createEvent = event
            this.createStart = event.start
            this.extendOriginal = event.end
        },
        mouseMove(tms) {
            const mouse = this.toTime(tms)
            if (this.dragEvent && this.dragTime !== null) {
                const start = this.dragEvent.start
                const end = this.dragEvent.end
                const duration = end - start
                const newStartTime = mouse - this.dragTime
                const newStart = this.roundTime(newStartTime)
                const newEnd = newStart + duration
                this.dragEvent.start = newStart
                this.dragEvent.end = newEnd
            } else if (this.createEvent && this.createStart !== null) {
                const mouseRounded = this.roundTime(mouse, false)
                const min = Math.min(mouseRounded, this.createStart)
                const max = Math.max(mouseRounded, this.createStart)
                this.createEvent.start = min
                this.createEvent.end = max
            }
        },
        endDrag() {
            this.dragTime = null
            this.dragEvent = null
            this.createEvent = null
            this.createStart = null
            this.extendOriginal = null
        },
        cancelDrag() {
            if (this.createEvent) {
                if (this.extendOriginal) {
                    this.createEvent.end = this.extendOriginal
                } else {
                    const i = this.events.indexOf(this.createEvent)
                    if (i !== -1) {
                        this.events.splice(i, 1)
                    }
                }
            }
            this.createEvent = null
            this.createStart = null
            this.dragTime = null
            this.dragEvent = null
        },
        roundTime(time, down = true) {
            const roundTo = 15 // minutes
            const roundDownTime = roundTo * 60 * 1000
            return down ?
                time - time % roundDownTime :
                time + (roundDownTime - (time % roundDownTime))
        },
        toTime(tms) {
            return new Date(tms.year, tms.month - 1, tms.day, tms.hour, tms.minute).getTime()
        },
        getEventColor(event) {
            const rgb = parseInt(event.color.substring(1), 16)
            const r = (rgb >> 16) & 0xFF
            const g = (rgb >> 8) & 0xFF
            const b = (rgb >> 0) & 0xFF
            return event === this.dragEvent ?
                `rgba(${r}, ${g}, ${b}, 0.7)` :
                event === this.createEvent ?
                `rgba(${r}, ${g}, ${b}, 0.7)` :
                event.color
        },
        rnd(a, b) {
            return Math.floor((b - a + 1) * Math.random()) + a
        },
        rndElement(arr) {
            return arr[this.rnd(0, arr.length - 1)]
        },
        viewDay({ date }) {
            this.value = date
            this.type = 'day'
        },
        fetchEvents() {
            this.$emit("fetchEvents", this.value);
        },
        updateEvent(event) {
            this.$emit("updateEvent", event);
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