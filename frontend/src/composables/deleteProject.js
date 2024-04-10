import { useAccountStore } from "@/stores/AccountStore"

const accountStore = useAccountStore();

const deleteProject = (error) => {
    const remove = async (project) => {
        try {
            error.value = null

            let response = await fetch('http://localhost/api/projects/' + project.id, {
                method: "DELETE",
                headers: {
                    authorization: 'Bearer ' + accountStore.token
                }
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

    return { remove }
}

export default deleteProject