import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useAccountStore = defineStore("account", () => {
    const token = ref(null);
    const user = ref(null);

    const isLoggedIn = computed(() => token.value !== null && user.value !== null);
    const isAdmin = computed(() => isLoggedIn.value && user.value.isAdmin);

    async function login(username, password) {
        let response = await fetch(`${window.location.protocol}//${window.location.hostname}/api/login`, {
            method: "POST",
            headers: {
            "Content-Type": "application/json",
            },
            body: JSON.stringify({ username, password })
        })

        let data = await response.json();
        if(!response.ok || data.errorMessage) {
            throw Error(data.errorMessage);
        }

        token.value = data.token;
        user.value = data.user;

        localStorage.setItem("token", token.value);
    }

    async function logout() {
        token.value = null;
        user.value = null;
        localStorage.removeItem("token");
    }

    async function register(username, email, password) {
        let response = await fetch(`${window.location.protocol}//${window.location.hostname}/api/register`, {
            method: "POST",
            headers: {
            "Content-Type": "application/json",
            },
            body: JSON.stringify({ username, email, password })
        })

        let data = await response.json();
        if(!response.ok || data.errorMessage) {
            throw Error(data.errorMessage);
        }

        token.value = data.token;
        user.value = data.user;

        localStorage.setItem("token", token.value);
    }

    async function load() {
        let storedToken = localStorage.getItem("token");
        if(storedToken) {
            let response = await fetch(`${window.location.protocol}//${window.location.hostname}/api/verifytoken`, {
                headers: {
                    authorization: `Bearer ${storedToken}`
                }
            })

            let data = await response.json();
            if(!response.ok || data.errorMessage) {
                throw Error(data.errorMessage);
            }

            if (data.valid) {
                token.value = storedToken;
                user.value = data.user;
            } else {
                localStorage.removeItem("token");
            }
        }
    }

    return {
        token,
        user,
        isLoggedIn,
        isAdmin,
        login,
        logout,
        register,
        load
    }
});