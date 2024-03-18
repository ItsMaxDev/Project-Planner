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
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-1/3 flex justify-center">
            <div class="bg-white p-4 rounded shadow text-black w-fit">
                <h2 class="text-lg font-bold mb-2">{{ question }}</h2>
                <div class="flex justify-end">
                    <button @click="$emit('no')" class="px-4 py-2 mr-2 bg-gray-200 rounded">No</button>
                    <button @click="$emit('yes')" class="px-4 py-2 bg-red-500 text-white rounded">Yes</button>
                </div>
            </div>
        </div>
    </div>
</template>