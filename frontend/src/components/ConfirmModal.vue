<script setup>
defineProps({
    question: {
        type: String,
        required: true
    }
})

defineEmits(['yes', 'no'])
</script>

<template>
    <teleport to="body">
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 p-5">
            <div class="flex justify-center">
                <div class="bg-base-200 p-4 rounded-lg shadow w-fit">
                    <h2 class="text-lg font-bold mb-2">{{ question }}</h2>
                    <div class="flex justify-end">
                        <button @click="$emit('no')" class="px-4 py-2 mr-2 btn btn-neutral">No</button>
                        <button @click="$emit('yes')" class="px-4 py-2 btn btn-error">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>