<script setup>
import Project from '../components/Project.vue'
import ConfirmModal from '../components/ConfirmModal.vue'
import { computed, onMounted, ref } from 'vue';
import router from '@/router';

// Composables
import getProjects from '../composables/getProjects'
import deleteProject from '../composables/deleteProject'
import updateProject from '../composables/updateProject'
import Alert from '@/components/Alert.vue';

const error = ref(null)
const { projects, load } = getProjects(error)
const { remove } = deleteProject(error)
const { update } = updateProject(error)

const showRemoveModal = ref(false)
const selectedProject = ref(null)

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

onMounted(async () => {
    await load()
})

async function updateStatus(project) {
  switch (project.status) {
    case 'NOT_STARTED':
      project.status = "IN_PROGRESS"
      break
    case 'IN_PROGRESS':
      project.status = "FINISHED"
      break
    case 'FINISHED':
      project.status = "NOT_STARTED"
      break
  }

  await update(project)
}

function editProject(project) {
  router.push({ name: 'editproject', params: { id: project.id } })
}

function removeProject(project) {
  selectedProject.value = project
  showRemoveModal.value = true
}

async function confirmRemoveProject() {
  closeRemoveProjectModal()
  
  await remove(selectedProject.value)

  if (!error.value) {
    projects.value = projects.value.filter(p => p.id !== selectedProject.value.id)
  }

  selectedProject.value = null
}

function closeRemoveProjectModal() {
  showRemoveModal.value = false
}

</script>

<template>
  <div class="flex flex-col items-center mt-20">
    <div class="w-1/2 flex justify-between">
      <h1 class="font-bold">Simple Project Planner</h1>
      <button @click="$router.push({ name: 'addproject' })" class="btn btn-primary"><span class="material-icons">add</span>Create project</button>
    </div>
    <div class="w-1/2 flex space-x-4">
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
    <Alert v-if="error" :message="error" type="error" class="w-1/2 mt-5" />
    <Alert v-else-if="!filteredProjects.length" message="No data available." class="w-1/2 mt-5" />
    <div v-if="filteredProjects.length" class="w-1/2 overflow-y-auto space-y-2" style="max-height: 650px;">
      <div v-for="project in filteredProjects" :key="project.id">
        <Project :project="project" @delete="removeProject(project)" @edit="editProject(project)" @updateStatus="updateStatus(project)" class="mb-1.5 mt-1.5"/>
      </div>
    </div>
  </div>
  <ConfirmModal v-if="showRemoveModal" question="Are you sure you want to remove this project?" @yes="confirmRemoveProject" @no="closeRemoveProjectModal" />
</template>