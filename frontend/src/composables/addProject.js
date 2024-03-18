const addProject = (error) => {
    const add = async (project) => {
        try {
            error.value = null

            let response = await fetch('http://localhost:3000/projects', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(project)
            })
                
            if(!response.ok) {
                throw Error('Could not add project.')
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