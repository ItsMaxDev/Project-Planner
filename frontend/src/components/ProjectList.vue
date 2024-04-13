<script setup>
import Project from './Project.vue'
import deleteProject from '@/composables/deleteProject';
import updateProject from '@/composables/updateProject';
import { useRouter } from 'vue-router';
import ConfirmModal from './ConfirmModal.vue';
import { ref } from 'vue';

const router = useRouter();
const emits = defineEmits(['delete']);
const props = defineProps({
  projects: {
    type: Array,
    required: true
  }
});

// Data
const showRemoveModal = ref(false);
const selectedProject = ref(null);

// Methods
const { remove } = deleteProject();
const { update } = updateProject();

const removeProject = (project) => {
  showRemoveModal.value = true;
  selectedProject.value = project;
}

const confirmRemove = async () => {
  try {
    await remove(selectedProject.value);
    emits('delete', selectedProject.value);
    cancelRemove();
  } catch (error) {
    console.error(error)
  }
}

const cancelRemove = () => {
  showRemoveModal.value = false;
  selectedProject.value = null;
}

const editProject = (project) => {
  router.push({ 
    name: 'editproject', 
    params: { 
      id: project.id 
    } 
  })
}

const updateStatus = async (project) => {
    const previousStatus = project.status;
    try {
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
    } catch (error) {
        console.error(error)
        project.status = previousStatus
    }
}

</script>

<template>
  <div v-if="projects.length" class="grid lg:max-h-[70vh] lg:overflow-y-auto">
    <Project class="mt-1.5 mb-1.5" v-for="project in projects" :key="project.id" :project="project" @delete="removeProject(project)" @edit="editProject(project)" @updateStatus="updateStatus(project)" />
    <ConfirmModal v-if="showRemoveModal" question="Are you sure you want to remove this project?" @yes="confirmRemove" @no="cancelRemove" />
  </div>
</template>