const updateProject = (error) => {
    const update = async (project) => {
        try {
            error.value = null
            
            let response = await fetch('http://localhost:3000/projects/' + project.id, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(project)
            })
                
            if(!response.ok) {
                throw Error('Could not update project.')
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