<script setup>
import { ref, watch } from 'vue';

const emits = defineEmits(['change']);

const selectedFilter = ref('all');

watch(selectedFilter, (newValue) => {
  emits('change', newValue);
});
</script>

<template>
  <div class="flex space-x-4">
    <div class="form-control">
      <label class="label cursor-pointer flex-row-reverse ps-0">
        <span class="label-text ms-1.5">All</span> 
        <input type="radio" name="radio-10" class="radio checked:bg-blue-500" v-model="selectedFilter" value="all" />
      </label>
    </div>
    <div class="form-control">
      <label class="label cursor-pointer flex-row-reverse ps-0">
        <span class="label-text ms-1.5">Not Started</span> 
        <input type="radio" name="radio-10" class="radio checked:bg-gray-500" v-model="selectedFilter" value="NOT_STARTED" />
      </label>
    </div>
    <div class="form-control">
      <label class="label cursor-pointer flex-row-reverse ps-0">
        <span class="label-text ms-1.5">In Progress</span> 
        <input type="radio" name="radio-10" class="radio checked:bg-orange-500" v-model="selectedFilter" value="IN_PROGRESS"/>
      </label>
    </div>
    <div class="form-control">
      <label class="label cursor-pointer flex-row-reverse ps-0">
        <span class="label-text ms-1.5">Finished</span> 
        <input type="radio" name="radio-10" class="radio checked:bg-green-500" v-model="selectedFilter" value="FINISHED" />
      </label>
    </div>
  </div>
</template>