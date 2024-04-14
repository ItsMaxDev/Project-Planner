<script setup>
import { ref } from 'vue';
import { useAccountStore } from '@/stores/AccountStore';
import Alert from './Alert.vue';

const accountStore = useAccountStore();

// Data
const error = ref('');
const username = ref('');
const email = ref('');
const password = ref('');
const signup = ref(false);

const login = async () => {
    try {
        await accountStore.login(username.value, password.value);
    } catch (err) {
        error.value = err.message;
    }
};

const register = async () => {
    try {
        await accountStore.register(username.value, email.value, password.value);
    } catch (err) {
        error.value = err.message;
    }
};
</script>

<template>
    <div class="flex items-center justify-center h-screen">
        <div class="flex flex-col">
            <Alert v-if="error" :message="error" type="error" class="mb-2 rounded-lg" />
            <form v-if="!signup" @submit.prevent="login" class="w-full">
                <div class="bg-base-300 p-5 rounded-lg shadow-lg">
                    <h1 class="text-center">Login</h1>
                    <div class="mt-4 flex flex-col">
                        <label class="mb-1">Username</label>
                        <input v-model="username" type="text" maxlength="16" class="input input-bordered" required>
                    </div>
                    <div class="mt-4 flex flex-col">
                        <label class="mb-1">Password</label>
                        <input v-model="password" type="password" class="input input-bordered" required>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button class="btn btn-primary w-full">Login</button>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <p>Don't have an account? <a @click="signup = true" class="link link-info">Sign up</a></p>
                    </div>
                </div>
            </form>
            <form v-else @submit.prevent="register" class="w-full">
                <div class="bg-base-300 p-5 rounded-lg shadow-lg">
                    <h1 class="text-center">Sign up</h1>
                    <div class="mt-4 flex flex-col">
                        <label class="mb-1">Username</label>
                        <input v-model="username" type="text" maxlength="16" class="input input-bordered" required>
                    </div>
                    <div class="mt-4 flex flex-col">
                        <label class="mb-1">Email</label>
                        <input v-model="email" type="email" class="input input-bordered" required>
                    </div>
                    <div class="mt-4 flex flex-col">
                        <label class="mb-1">Password</label>
                        <input v-model="password" type="password" class="input input-bordered" required>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button class="btn btn-primary w-full">Sign up</button>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <p>Already have an account? <a @click="signup = false" class="link link-info">Login</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>