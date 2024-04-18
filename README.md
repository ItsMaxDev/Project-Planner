<a href="https://projects.maxkruiswegt.com/">
    <img src="https://imgur.com/QxsxS7e.png" alt="Project Planner" width="600" style="margin-bottom: 10px;">
</a>

Welcome to Project Planner, a dynamic project management web application! It's built using Vue 3 for the frontend and PHP for the backend, creating a seamless single-page application experience. The frontend communicates with the backend via API calls, which are processed and interacted with the database by the backend.

Project Planner allows you to manage your projects effectively. Here's what you can do:

- 🆕 **Create an account**: Get started by creating your own account.
- 📋 **View a list of projects**: See all your projects in one place.
- 🔍 **Filter the list of projects**: Easily find the projects you need based on their status.
- ➕ **Add a project**: Start new projects with ease.
- ✏️ **Edit a project**: Make changes to your projects as needed.
- 🗑️ **Delete a project**: Remove projects that are no longer needed.
- 🔄 **Change the status of a project**: Keep track of your progress by updating the status of your projects.
- 📅 **Set due dates**: Plan your schedule by setting due dates for projects, which will show up to remind you.

### [🚀 Try it out!](https://projects.maxkruiswegt.com/)
<br>

## 🎨 Frontend

The frontend, located in the `frontend/` directory, is built with Vue 3 and Vite, and styled with Tailwind CSS. The source code is located in the `src/` subdirectory.

To get started with the frontend:
1. Navigate to the `frontend/` directory
2. Run `npm install` to install the necessary dependencies
3. Start the development server with `npm run dev`
4. To build the application for production, run `npm run build`

For more detailed instructions, please refer to the [frontend README](https://github.com/ItsMaxDev/Webdev-2-Project/blob/main/frontend/README.md).
<br>
<br>
## ⚙️ Backend

The backend, located in the `backend/` directory, is built with PHP and uses Docker for containerization. The source code is located in the `app/` subdirectory, which contains various PHP classes for controllers, models, and services.

To get started with the backend:
1. Navigate to the `backend/` directory
2. Run `docker compose up` to start the Docker containers

For more detailed instructions, please refer to the [backend README](https://github.com/ItsMaxDev/Webdev-2-Project/blob/main/backend/README.md).
<br>
<br>
## 🚀 Deployment

The project uses GitHub Actions for continuous integration and deployment. There are two workflows: one for the frontend and one for the backend. These workflows are triggered on push to the `main` branch and deploy the application to a web server. The workflows are defined in the `.github/workflows/` directory.