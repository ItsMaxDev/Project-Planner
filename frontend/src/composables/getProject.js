import { ref } from 'vue';

const getProject = (error) => {
    const project = ref(null);

    const get = async (id) => {
        try {
            error.value = null
            
            let response = await fetch('http://localhost:3000/projects/' + id)
                
            if(!response.ok) {
                throw Error('This project does not exist.')
            }

            project.value = await response.json()
        } 
        catch (err) {
            error.value = err.message
            console.error(err)
        }
    }

    return { project, get }
}

export default getProject