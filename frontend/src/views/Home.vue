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
  <div class="flex justify-center lg:pt-[10vh]">
    <div class="flex flex-col items-center w-full lg:w-3/4 xl:w-2/3 2xl:w-1/2 mx-5 mb-5 lg:mb-0">
      <div class="hidden lg:flex w-full justify-between">
        <h1 class="font-bold">Simple Project Planner</h1>
        <button @click="$router.push({ name: 'addproject' })" class="btn btn-primary"><span class="material-icons">add</span>Add project</button>
      </div>
      <h1 class="text-xl md:text-3xl lg:hidden font-bold mt-10 self-start">Simple Project Planner</h1>
      <div class="lg:hidden fixed bottom-5">
        <button @click="$router.push({ name: 'addproject' })" class="btn btn-primary opacity-95"><span class="material-icons">add</span>Add project</button>
      </div>
      <ProjectFilters @change="selectedFilter = $event" class="w-full" />
      <Alert v-if="error" :message="error" type="error" class="w-full mt-5" />
      <Alert v-else-if="!filteredProjects.length" message="No data available." class="w-full mt-5" />
      <ProjectList :projects="filteredProjects" @delete="removeProject" class="w-full" />
    </div>
  </div>
  <footer class="lg:absolute bottom-5 text-center w-full mb-5 lg:mb-0">Made with ❤️ by <a href="https://github.com/ItsMaxDev" target="_blank" class="text-primary">Max Kruiswegt</a></footer>
</template>