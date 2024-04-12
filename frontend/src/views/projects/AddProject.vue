<script setup>
import { ref, watch } from 'vue';
import addProject from '../../composables/addProject'
import router from '@/router';
import Alert from '@/components/Alert.vue';

const error = ref(null)
const { add } = addProject(error)

const name = ref('')
const description = ref(null)
const due_date = ref(null)

async function createProject() {
    const project = { name: name.value, description: description.value, due_date: due_date.value }
    await add(project)

    if(!error.value) {
        router.push({ name: 'home' })
    }
}

watch([due_date, description], ([due_dateValue, descriptionValue]) => {
    due_date.value = due_dateValue || null
    description.value = descriptionValue || null
})
</script>

<template>
    <div class="flex flex-col items-center mt-40">
        <Alert v-if="error" :message="error" type="error" class="w-1/4 mb-2 rounded-lg" />
        <button class="btn btn-neutral w-1/4" @click="$router.push({ name: 'home' })"><span class="material-icons">arrow_back</span>Go back to projects</button>
        <form @submit.prevent="createProject" class="w-1/4 mt-2">
            <div class="bg-base-300 p-5 rounded-lg shadow-lg">
                <h1 class="text-center">Add Project</h1>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Name</label>
                    <input v-model="name" type="text" placeholder="My project" class="input input-bordered" required>
                </div>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Description</label>
                    <textarea v-model="description" rows="5" class="textarea textarea-bordered"></textarea>
                </div>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Due Date</label>
                    <input v-model="due_date" type="datetime-local" class="input input-bordered">
                </div>
                <div class="mt-4 flex justify-end">
                    <button class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </div>
</template>