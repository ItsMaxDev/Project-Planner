<script setup>
import { onMounted, ref, watch } from 'vue';
import getProject from '../../composables/getProject'
import updateProject from '../../composables/updateProject'
import router from '@/router';
import Alert from '@/components/Alert.vue';

onMounted(async () => {
    try {
        await get(props.id)

        watch([() => project.value.due_date, () => project.value.description], ([dueDateValue, descriptionValue]) => {
            project.value.due_date = dueDateValue || null;
            project.value.description = descriptionValue || null;
        });
    } catch (err) {
        console.error(err)
        error.value = err.message
    }
})

const error = ref(null)
const { update } = updateProject()
const { project, get } = getProject(error)

const props = defineProps(['id'])

const editProject = async () => {
    try {
        await update(project.value)
        router.push({ name: 'home' })
    } catch (err) {
        console.error(err)
        error.value = err.message
    }
}
</script>

<template>
    <div class="flex flex-col items-center mt-40">
        <Alert v-if="error" :message="error" type="error" class="w-1/4 mb-2 rounded-lg" />
        <button class="btn btn-neutral w-1/4" @click="$router.push({ name: 'home' })"><span class="material-icons">arrow_back</span>Go back to projects</button>
        <form v-if="project" @submit.prevent="editProject" class="w-1/4 mt-2">
            <div class="bg-base-300 p-5 rounded-lg shadow-lg">
                <h1 class="text-center">Edit Project</h1>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Name</label>
                    <input v-model="project.name" type="text" placeholder="My project" maxlength="32" class="input input-bordered" required>
                </div>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Description</label>
                    <textarea v-model="project.description" rows="5" maxlength="65535" class="textarea textarea-bordered"></textarea>
                </div>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Due Date</label>
                    <input v-model="project.due_date" type="datetime-local" class="input input-bordered">
                </div>
                <div class="mt-4 flex justify-end">
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</template>