import { useAccountStore } from "@/stores/AccountStore"

const accountStore = useAccountStore();

const updateProject = (error) => {
    const update = async (project) => {
        try {
            error.value = null
            
            let response = await fetch('http://localhost/api/projects/' + project.id, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    authorization: 'Bearer ' + accountStore.token
                },
                body: JSON.stringify(project)
            })
                
            let data = await response.json();
            if(!response.ok || data.errorMessage) {
                throw Error(data.errorMessage);
            }
        } 
        catch (err) {
            error.value = err.message
            console.error(err)
        }
    }

    return { update }
}

export default updateProject