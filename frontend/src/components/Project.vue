<script setup>
import { computed, ref } from 'vue';

const emits = defineEmits(['delete', 'edit', 'updateStatus']);
const props = defineProps({
    project: {
        type: Object,
        required: true,
        validator: function (object) {
            return 'id' in object && 
                   'userid' in object && 
                   'name' in object && 
                   'description' in object && 
                   'status' in object && 
                   'creation_date' in object && 
                   'due_date' in object;
        }
    }
})

// Data
const showDescription = ref(false);
const icon = computed(() => {
    switch (props.project.status) {
    case 'NOT_STARTED':
      return 'not_started';
    case 'IN_PROGRESS':
      return 'pending'
    case 'FINISHED':
      return 'check_circle'
  }
})
</script>

<template>
    <div v-if="project">
        <div class="p-10 bg-base-300 rounded-lg text-bl shadow-lg border-l-8" :class="{ 'border-gray-500': project.status === 'NOT_STARTED', 'border-orange-500': project.status === 'IN_PROGRESS', 'border-green-500': project.status === 'FINISHED' }">
            <div class="flex justify-between items-center">
                <span @click="showDescription = !showDescription" class="material-icons">{{ showDescription ? 'expand_more' : 'chevron_right' }}</span>
                <h2>{{ project.name }}</h2>
                <div class="flex items-center space-x-1">
                    <span @click="$emit('delete')" class="material-icons hover:text-red-500">delete</span>
                    <span @click="$emit('edit')" class="material-icons hover:text-orange-500">edit</span>
                    <span @click="$emit('updateStatus')" class="material-icons" :class="{ 'text-gray-500': project.status === 'NOT_STARTED', 'text-orange-500': project.status === 'IN_PROGRESS', 'text-green-500': project.status === 'FINISHED' }">{{ icon }}</span>
                </div>
            </div>
            <div v-if="showDescription" class="mt-5">
                <p>{{ project.description }}</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.material-icons {
    @apply hover:bg-white;
    @apply hover:bg-opacity-10;
    @apply hover:rounded-full;
    @apply select-none;
    @apply cursor-pointer;
    @apply p-2;
}
</style>