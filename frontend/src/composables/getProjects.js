import { useAccountStore } from '@/stores/AccountStore';
import { ref } from 'vue';

const accountStore = useAccountStore();

const getProjects = (error) => {
    const projects = ref([]);

    const load = async () => {
        try {
            error.value = null
            
            let response = await fetch('http://localhost/api/projects', {
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
        catch (err) {
            error.value = err.message
            console.error(err)
        }
    }

    return { projects, load }
}

export default getProjects