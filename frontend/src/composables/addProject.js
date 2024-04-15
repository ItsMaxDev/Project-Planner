import { useAccountStore } from '@/stores/AccountStore';

const accountStore = useAccountStore();

const addProject = () => {
    const add = async (project) => {
        let response = await fetch(`${window.location.protocol}//${window.location.hostname}/api/projects`, {
            method: "POST",
            headers: {
            "Content-Type": "application/json",
            authorization: 'Bearer ' + accountStore.token
            },
            body: JSON.stringify({
            userid: accountStore.user.id,
            name: project.name,
            description: project.description,
            due_date: project.due_date
            })
        })

        let data = await response.json();
        if(!response.ok || data.errorMessage) {
            throw Error(data.errorMessage);
        }
    }

    return { add }
}

export default addProject