<script setup>
import Project from '../components/Project.vue'
import ConfirmModal from '../components/ConfirmModal.vue'
import { computed, onMounted, ref, watch } from 'vue';
import router from '@/router';

// Composables
import getProjects from '../composables/getProjects'
import deleteProject from '../composables/deleteProject'
import updateProject from '../composables/updateProject'

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
        .filter(project => project.status === 'notStarted')
        .concat(projects.value.filter(project => project.status === 'inProgress'))
        .concat(projects.value.filter(project => project.status === 'finished'));
    case 'notStarted':
      return projects.value.filter(p => p.status === 'notStarted');
    case 'inProgress':
      return projects.value.filter(p => p.status === 'inProgress');
    case 'finished':
      return projects.value.filter(p => p.status === 'finished');
  }
});

onMounted(async () => {
    await load()
})

async function updateStatus(project) {
  switch (project.status) {
    case 'notStarted':
      project.status = "inProgress"
      break
    case 'inProgress':
      project.status = "finished"
      break
    case 'finished':
      project.status = "notStarted"
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
  await remove(selectedProject.value)
  projects.value = projects.value.filter(p => p.id !== selectedProject.value.id)
  closeRemoveProjectModal()
}

function closeRemoveProjectModal() {
  selectedProject.value = null
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
          <input type="radio" name="radio-10" class="radio checked:bg-gray-500" v-model="selectedFilter" value="notStarted" />
        </label>
      </div>
      <div class="form-control">
        <label class="label cursor-pointer flex-row-reverse ps-0">
          <span class="label-text ms-1.5">In Progress</span> 
          <input type="radio" name="radio-10" class="radio checked:bg-orange-500" v-model="selectedFilter" value="inProgress"/>
        </label>
      </div>
      <div class="form-control">
        <label class="label cursor-pointer flex-row-reverse ps-0">
          <span class="label-text ms-1.5">Finished</span> 
          <input type="radio" name="radio-10" class="radio checked:bg-green-500" v-model="selectedFilter" value="finished" />
        </label>
      </div>
    </div>
    <div v-if="error" class="w-1/2 mt-5">
      <div role="alert" class="alert alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>{{ error }}</span>
      </div>
    </div>
    <div v-if="filteredProjects.length" class="w-1/2 overflow-y-auto space-y-2" style="max-height: 650px;">
      <div v-for="project in filteredProjects" :key="project.id">
        <Project :project="project" @delete="removeProject" @edit="editProject" @updateStatus="updateStatus" class="mb-1.5 mt-1.5"/>
      </div>
    </div>
    <div v-if="!filteredProjects.length && !error" class="w-1/2 mt-5">
      <div role="alert" class="alert">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>No data available.</span>
      </div>
    </div>
  </div>
  <ConfirmModal v-if="showRemoveModal" question="Are you sure you want to remove this project?" @yes="confirmRemoveProject" @no="closeRemoveProjectModal" />
</template>