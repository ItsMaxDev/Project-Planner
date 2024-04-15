import { useAccountStore } from '@/stores/AccountStore';
import { ref } from 'vue';

const accountStore = useAccountStore();

const getProjects = () => {
    const projects = ref([]);

    const load = async () => {
        let response = await fetch(`${window.location.protocol}//${window.location.hostname}/api/projects`, {
            headers: {
            authorization: 'Bearer ' + accountStore.token
            }
        })
        
        let data = await response.json();
        if(!response.ok || data.errorMessage) {
            throw Error(data.errorMessage);
        }

        projects.value = data;
    }

    return { projects, load }
}

export default getProjects