<script setup>
import { onMounted, ref } from 'vue';
import getProject from '../../composables/getProject'
import updateProject from '../../composables/updateProject'
import router from '@/router';

const error = ref(null)
const { update } = updateProject(error)
const { project, get } = getProject(error)

const props = defineProps(['id'])

onMounted(async () => {
    await get(props.id)
})

async function editProject() {
    await update(project.value)

    if(!error.value) {
        router.push({ name: 'home' })
    }
}

</script>

<template>
    <div class="flex flex-col items-center mt-20">
        <div v-if="error" role="alert" class="alert alert-error w-1/4 mb-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ error }}</span>
        </div>
        <button class="btn btn-neutral w-1/4" @click="$router.push({ name: 'home' })"><span class="material-icons">arrow_back</span>Go back to projects</button>
        <form v-if="project" @submit.prevent="editProject" class="w-1/4 mt-2">
            <div class="bg-base-300 p-5 rounded-lg shadow-lg">
                <h1 class="text-center">Edit Project</h1>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Name</label>
                    <input v-model="project.name" type="text" placeholder="My project" class="input input-bordered" required>
                </div>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Description</label>
                    <textarea v-model="project.description" rows="5" class="textarea textarea-bordered" required></textarea>
                </div>
                <div class="mt-4 flex justify-end">
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</template>