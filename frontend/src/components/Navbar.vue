<script setup>
import { useAccountStore } from '@/stores/AccountStore';

const accountStore = useAccountStore();
</script>

<template>
    <div v-if="accountStore.isLoggedIn">
        <div class="flex justify-end">
            <RouterLink :to="{ name: 'profile' }" class="mt-5 me-5 flex items-center font-bold gap-1.5">
                <span class="material-symbols-outlined">
                    account_circle
                </span>
                <p>{{ accountStore.user.username }}</p>
            </RouterLink>
        </div>
    </div>
</template>