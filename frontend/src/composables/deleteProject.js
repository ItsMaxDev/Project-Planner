import { useAccountStore } from "@/stores/AccountStore"

const accountStore = useAccountStore();

const deleteProject = () => {
    const remove = async (project) => {
        let response = await fetch(`${window.location.protocol}//${window.location.hostname}:3000/api/projects/${project.id}`, {
            method: "DELETE",
            headers: {
                authorization: 'Bearer ' + accountStore.token
            }
        });
            
        let data = await response.json();
        if(!response.ok || data.errorMessage) {
            throw Error(data.errorMessage);
        }
    }

    return { remove }
}

export default deleteProject