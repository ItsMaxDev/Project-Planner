import { useAccountStore } from "@/stores/AccountStore"

const accountStore = useAccountStore();

const updateProject = () => {
    const update = async (project) => {
        let response = await fetch(`${window.location.protocol}//${window.location.hostname}:3000/api/projects/${project.id}`, {
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

    return { update }
}

export default updateProject