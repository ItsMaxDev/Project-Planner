<script setup>
import { computed, onMounted, ref } from 'vue';
import getProjects from '../composables/getProjects';
import Alert from '@/components/Alert.vue';
import ProjectList from '@/components/ProjectList.vue';
import ProjectFilters from '@/components/ProjectFilters.vue';

onMounted(async () => {
  try {
    await load();
  } catch (err) {
    console.error(err);
    error.value = err.message;
  }
})

const error = ref(null);
const { projects, load } = getProjects();

const selectedFilter = ref('all');
const filteredProjects = computed(() => {
  switch (selectedFilter.value) {
    case 'all':
      return projects.value
        .filter(project => project.status === 'NOT_STARTED')
        .concat(projects.value.filter(project => project.status === 'IN_PROGRESS'))
        .concat(projects.value.filter(project => project.status === 'FINISHED'));
    case 'NOT_STARTED':
      return projects.value.filter(p => p.status === 'NOT_STARTED');
    case 'IN_PROGRESS':
      return projects.value.filter(p => p.status === 'IN_PROGRESS');
    case 'FINISHED':
      return projects.value.filter(p => p.status === 'FINISHED');
  }
});

const removeProject = (project) => {
  const index = projects.value.findIndex(p => p.id === project.id)
  projects.value.splice(index, 1)
}
</script>

<template>
  <div class="flex flex-col items-center mt-20">
    <div class="w-1/2 flex justify-between">
      <h1 class="font-bold">Simple Project Planner</h1>
      <button @click="$router.push({ name: 'addproject' })" class="btn btn-primary"><span class="material-icons">add</span>Create project</button>
    </div>
    <ProjectFilters @change="selectedFilter = $event" class="w-1/2" />
    <Alert v-if="error" :message="error" type="error" class="w-1/2 mt-5" />
    <Alert v-else-if="!filteredProjects.length" message="No data available." class="w-1/2 mt-5" />
    <ProjectList :projects="filteredProjects" @delete="removeProject" class="w-1/2" />
  </div>
</template>