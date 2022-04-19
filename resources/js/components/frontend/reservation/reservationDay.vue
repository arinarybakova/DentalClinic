<template>
    <td>
        <div v-for="time in times" v-bind:key="time" class="radio-custom">
            <input type="radio" v-model="selected" :value="time" :id="date + '/' + time" name="time" v-on:change="setTime(time, date)" />
            <label :for="date + '/' + time">{{ time }}</label>
        </div>
    </td>
</template>
<script>
export default {
    props: {
        times: { required: true },
        date: { required: true},
    },
    data() {
        return {
            selected: "",
        };
    },
    methods: {
        setTime(time, date) {
            this.$emit("setTime", [date, time ]);
        }
    },
};
</script>