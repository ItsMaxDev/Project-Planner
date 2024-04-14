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
const statusIcon = computed(() => {
    switch (props.project.status) {
    case 'NOT_STARTED':
      return 'not_started';
    case 'IN_PROGRESS':
      return 'pending'
    case 'FINISHED':
      return 'check_circle'
  }
})

// Compute the remaining time until the due date
const remainingTime = computed(() => {
    if (!props.project.due_date) return '';

    const dueDate = new Date(props.project.due_date);
    const now = new Date();
    const diff = dueDate - now;
    const months = Math.floor(diff / (1000 * 60 * 60 * 24 * 30));
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

    let message = '';
    let color = '';
    switch (true) {
        case months > 0:
            message = `Due in ${months} months and ${days-30*months} days`;
            color = 'text-green-500';
            break;
        case days > 0:
            message = `Due in ${days} days`;
            color = 'text-green-500';
            break;
        case hours > 0:
            message = `Due in ${hours} hours`;
            color = 'text-yellow-500';
            break;
        case minutes > 0:
            message = `Due in ${minutes} minutes`;
            color = 'text-orange-500';
            break;
        case seconds > 0:
            message = `Due in ${seconds} seconds`;
            color = 'text-red-500';
            break;
        case diff < 0:
            message = 'Overdue';
            color = 'text-red-500';
            break;
    }

    return { message, color };
});
</script>

<template>
    <div v-if="project">
        <div class="p-10 bg-base-300 rounded-lg text-bl shadow-lg border-t-8 md:border-t-0 md:border-l-8" 
            :class="{ 
                'border-gray-500': project.status === 'NOT_STARTED', 
                'border-orange-500': project.status === 'IN_PROGRESS', 
                'border-green-500': project.status === 'FINISHED' }">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <span @click="project.description && (showDescription = !showDescription)" class="material-icons hidden md:flex" :class="{ 'opacity-50': !project.description }">{{ showDescription ? 'expand_more' : 'chevron_right' }}</span>
                <div class="flex flex-col items-center gap-2">
                    <p v-if="remainingTime" class="flex items-center gap-2" :class="remainingTime.color"><span class="material-symbols-outlined">schedule</span> {{ remainingTime.message }}</p>
                    <h2 class="text-center whitespace-pre-wrap break-all">{{ project.name }}</h2>
                </div>
                <div class="flex items-center space-x-1">
                    <span @click="project.description && (showDescription = !showDescription)" class="material-icons md:hidden" :class="{ 'opacity-50': !project.description }">{{ showDescription ? 'expand_more' : 'chevron_right' }}</span>
                    <span @click="$emit('delete')" class="material-icons hover:text-red-500">delete</span>
                    <span @click="$emit('edit')" class="material-icons hover:text-orange-500">edit</span>
                    <span @click="$emit('updateStatus')" class="material-icons" 
                        :class="{ 
                            'text-gray-500': project.status === 'NOT_STARTED', 
                            'text-orange-500': project.status === 'IN_PROGRESS', 
                            'text-green-500': project.status === 'FINISHED' }">
                        {{ statusIcon }}
                    </span>
                </div>
            </div>
            <div v-if="showDescription" class="mt-5 max-h-[25vh] overflow-y-auto">
                <p class="whitespace-pre-wrap break-all">{{ project.description }}</p>
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