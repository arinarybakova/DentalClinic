<template>
  <div v-if="validation.$error" class="text-danger mt-1">
    <p v-for="error in validation.$errors" :key="error.$uid">
      {{ error.$message }}
    </p>
  </div>
</template>
<script>
export default {
  props: ["validation"],
};
</script>