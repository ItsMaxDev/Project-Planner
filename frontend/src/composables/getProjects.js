import { ref } from 'vue';

const getProjects = (error) => {
    const projects = ref([]);

    const load = async () => {
        try {
            error.value = null
            
            let response = await fetch('http://localhost:3000/projects')
                
            if(!response.ok) {
                throw Error('Could not fetch data.')
            }

            projects.value = await response.json()
        } 
        catch (err) {
            error.value = err.message
            console.error(err)
        }
    }

    return { projects, load }
}

export default getProjects