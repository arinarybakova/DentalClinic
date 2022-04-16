<template>
    <td>
        <div v-for="time in times" v-bind:key="time">
            {{ time }}
        </div>
    </td>
</template>
<script>
export default {
    props: {
        times: { required: true },
    },
    watch: {
        times: {
            handler: function(value) {
                console.log(times);
            },
        },
    },
};
</script>