import { useAccountStore } from '@/stores/AccountStore';

const accountStore = useAccountStore();

const addProject = (error) => {
    const add = async (project) => {
        try {
            error.value = null

            let response = await fetch('http://localhost/api/projects', {
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
        catch (err) {
            error.value = err.message
            console.error(err)
        }
    }

    return { add }
}

export default addProject