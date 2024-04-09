<script setup>
import { ref } from 'vue';
import { useAccountStore } from '@/stores/AccountStore';

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
    <div class="flex flex-col items-center justify-center h-screen">
        <div v-if="error" role="alert" class="alert alert-error w-2/12 mb-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current s</div>hrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ error }}</span>
        </div>
        <form v-if="!signup" @submit.prevent="login" class="w-2/12">
            <div class="bg-base-300 p-5 rounded-lg shadow-lg">
                <h1 class="text-center">Login</h1>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Username</label>
                    <input v-model="username" type="text" class="input input-bordered" required>
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
        <form v-else @submit.prevent="register" class="w-2/12">
            <div class="bg-base-300 p-5 rounded-lg shadow-lg">
                <h1 class="text-center">Sign up</h1>
                <div class="mt-4 flex flex-col">
                    <label class="mb-1">Username</label>
                    <input v-model="username" type="text" class="input input-bordered" required>
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
</template>