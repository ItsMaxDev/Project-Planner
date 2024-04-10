import { useAccountStore } from '@/stores/AccountStore';
import { ref } from 'vue';

const accountStore = useAccountStore();

const getProject = (error) => {
    const project = ref(null);

    const get = async (id) => {
        try {
            error.value = null
            
            let response = await fetch('http://localhost/api/projects/' + id, {
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
        catch (err) {
            error.value = err.message
            console.error(err)
        }
    }

    return { project, get }
}

export default getProject