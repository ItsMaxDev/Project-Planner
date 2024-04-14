import { useAccountStore } from '@/stores/AccountStore';
import { ref } from 'vue';

const accountStore = useAccountStore();

const getProject = () => {
    const project = ref(null);

    const get = async (id) => {
        let response = await fetch('http://localhost:3000/api/projects/' + id, {
            headers: {
                authorization: 'Bearer ' + accountStore.token
            }
        })
        
        let data = await response.json();
        if(!response.ok || data.errorMessage) {
            throw Error(data.errorMessage);
        }

        project.value = data;
    }

    return { project, get }
}

export default getProject