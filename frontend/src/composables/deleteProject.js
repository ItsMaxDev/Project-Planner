const deleteProject = (error) => {
    const remove = async (project) => {
        try {
            error.value = null
            
            let response = await fetch('http://localhost:3000/projects/' + project.id, {
                method: "DELETE"
            })
                
            if(!response.ok) {
                throw Error('Could not delete project.')
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