<template>
    <div>
        <section class="services" id="services">
            <h1 class="heading">Vizito <span>rezervacija</span></h1>
            <div class="box-container">
                <toast type="error" :msg="errorToast.message" :show="errorToast.show" @toastClosed="errorToast.show = false"></toast>
                <b-form @submit="onSubmit">
                    <b-form-group id="doctor-group" label="Pasirinkite gyd. odontologą:" label-for="doctor-input">
                        <b-form-select 
                            id="doctor-input" 
                            v-model="form.doctor" 
                            :options="doctorOptions" 
                            class="form-control"
                            v-on:change="fetchAvailableTimes()" />
                    </b-form-group>
                    <form-error :validation="v$.form.doctor"></form-error>
                    <div class="row">
                        <div class="col-6">
                            <b-button variant="outline-info" v-on:click="prev()" v-if="minDate < monday">Atgal</b-button>
                        </div>
                        <div class="col-6 text-right">
                            <b-button variant="outline-info" v-on:click="next()">Pirmyn</b-button>
                        </div>
                    </div>
                    <table class="table b-table atable reservation-table my-3">
                        <thead>
                            <tr>
                                <th :class="getDisabled(1)">P <div v-text="getDay(1)"></div></th>
                                <th :class="getDisabled(2)">A <div v-text="getDay(2)"></div></th>
                                <th :class="getDisabled(3)">T <div v-text="getDay(3)"></div></th>
                                <th :class="getDisabled(4)">K <div v-text="getDay(4)"></div></th>
                                <th :class="getDisabled(5)">Pn <div v-text="getDay(5)"></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <reservation-day :times="times[getDay(1)]" />
                                <reservation-day :times="times[getDay(2)]" />
                                <reservation-day :times="times[getDay(3)]" />
                                <reservation-day :times="times[getDay(4)]" />
                                <reservation-day :times="times[getDay(5)]" />
                            </tr>
                        </tbody>
                    </table>
                    <b-button type="submit" variant="secondary" class="mt-3">Rezervuoti</b-button>
                </b-form>
            </div>
        </section>
    </div>
</template>
<script>
import useVuelidate from "@vuelidate/core";
import {
    required,
    minValue,
    helpers,
} from "@vuelidate/validators";

export default {
    setup() {
        return {
            v$: useVuelidate(),
        };
    },
    data() {
        return {
            form: {
                doctor: "",
            },
            errorToast: {
                message: "",
                show: false,
            },
            doctorOptions: [],
            monday: '',
            minDate: '',
            times: [],
        };
    },
    validations() {
        return {
            form: {
                doctor: {
                    required: helpers.withMessage(
                        "Prašome pasirinkti gydytoją",
                        required
                    ),
                    minValue: helpers.withMessage(
                        "Prašome pasirinkti gydytoją",
                        minValue(1)
                    ),
                },
            },
        };
    },
    created() {
        this.fetchAvailableTimes();
        this.fetchDoctors();
        this.getDate();
        this.minDate = this.monday;
    },
    methods: {
        onSubmit(event) {
            event.preventDefault();
            if (this.v$.$validate() && !this.v$.$error) {
                addReservation()
            }
        },
        getDate() {
            var today = new Date();
            var day = today.getDay() || 7;
            if(day !== 1)
                today.setHours(-24 * (day - 1));
            this.monday = today;
        },
        getDay(day) {
            var d = new Date();
            d.setDate(this.monday.getDate() + day - 1);
            return this.formatDate(d);
        },
        getDisabled(day) {
            var d = new Date();
            d.setDate(this.monday.getDate() + day - 1);
            return d < new Date() ? 'disabled' : '';
        },
        getTimes(day) {
            var d = new Date();
            d.setDate(this.monday.getDate() + day - 1);
            if(this.times[this.formatDate(d)] !== 'undefined') {
                console.log(this.times[this.formatDate(d)]);
                return this.times[this.formatDate(d)];
            } else {
                return [];
            }
        },
        formatDate(date) {
            return date.getFullYear() 
                + "-" + (date.getMonth() + 1).toString().padStart(2, "0") 
                + "-" + date.getDate().toString().padStart(2, "0");
        },
        next() {
            var d = new Date();
            d.setDate(this.monday.getDate() + 7);
            this.monday = d;
        },
        prev() {
            var d = new Date();
            d.setDate(this.monday.getDate() - 7);
            this.monday = d;
        },
        addReservation() {

        },
        resetForm() {
            this.form = {
                doctor: "",
            };
            this.v$.$reset();
        },
        fetchDoctors() {
            this.axios
                .get("/api/front/doctors")
                .then((response) => {
                    this.doctorOptions.push({ value: '', text: 'Pasirinkite gydytoją' });
                    for (var i = 0; i < response.data.length; i++) {
                        this.doctorOptions.push({ value: response.data[i].id, text: response.data[i].name });
                    }
                });
        },
        fetchAvailableTimes() {
            this.axios
                .get("/api/front/availableTimes?doctor=" + this.form.doctor)
                .then((response) => {
                    this.times = response.data;
                });
        }
    },
};
</script>