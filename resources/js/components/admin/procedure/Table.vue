<template>
    <b-table borderless hover head-variant='dark' :items="items"></b-table>
</template>
<script>
  export default {
    data() {
      return {
        items: []
      }
    },
    created () {
        this.axios.get('/api/procedures/').then(response => {
            this.items = response.data;
            console.log(response.data);
        });
    }
  }
</script>