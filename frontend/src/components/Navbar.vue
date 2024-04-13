<script setup>
import { useAccountStore } from '@/stores/AccountStore';

const accountStore = useAccountStore();
</script>

<template>
    <div v-if="accountStore.isLoggedIn">
        <div class="fixed top-5 right-5 flex justify-end">
            <RouterLink :to="{ name: 'profile' }" class="btn btn-neutral flex items-center font-bold gap-1.5 p-3">
                <span class="material-symbols-outlined">
                    account_circle
                </span>
                <p>{{ accountStore.user.username }}</p>
            </RouterLink>
        </div>
    </div>
</template>