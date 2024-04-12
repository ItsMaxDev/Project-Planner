<script setup>
import Alert from '@/components/Alert.vue';
import { useAccountStore } from '@/stores/AccountStore';
import { ref } from 'vue';

const accountStore = useAccountStore();

// Data
const error = ref('');

const logout = async () => {
    try {
        await accountStore.logout();
    } catch (err) {
        error.value = err.message;
    }
};
</script>

<template>
    <div class="flex flex-col items-center mt-40">
        <Alert v-if="error" :message="error" type="error" class="w-1/6 mb-2 rounded-lg" />
        <button class="btn btn-neutral w-1/6" @click="$router.push({ name: 'home' })"><span class="material-icons">arrow_back</span>Go back to projects</button>
        <div class="w-1/6 mt-2">
            <div class="bg-base-300 p-5 rounded-lg shadow-lg">
                <h1 class="text-center">Profile</h1>
                <div class="mt-4">
                    <label class="font-bold">ID:</label>
                    <span class="ml-2">{{ accountStore.user.id }}</span>
                </div>
                <div class="mt-4">
                    <label class="font-bold">Username:</label>
                    <span class="ml-2">{{ accountStore.user.username }}</span>
                </div>
                <div class="mt-4">
                    <label class="font-bold">Email:</label>
                    <span class="ml-2">{{ accountStore.user.email }}</span>
                </div>
                <div class="mt-4">
                    <label class="font-bold">Is Admin:</label>
                    <span class="ml-2" :class="accountStore.isAdmin ? 'badge badge-success' : 'badge badge-error'">{{ accountStore.isAdmin ? 'Yes' : 'No' }}</span>
                </div>
                <div class="mt-4">
                    <button @click="logout" class="btn btn-error w-full">Logout</button>
                </div>
            </div>
        </div>
    </div>
</template>