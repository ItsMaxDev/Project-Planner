# 🎨 Project Planner - Frontend

Welcome to the frontend of Project Planner, a dynamic project management web application! This part of the application is built using Vue 3, Vite and Pinia, and styled with Tailwind CSS. The frontend communicates with the backend via API calls, which are processed and interacted with the database by the backend.
<br>
<br>
## 🛠️ Project Setup

⚠️ Before you start, make sure you have [Node.js](https://nodejs.org/) installed on your machine. Node.js is required to run `npm` commands. 

First, open a terminal in the project directory. Then, install the project dependencies:

```bash
npm install
```

This will install all the necessary packages for the project, including Vue, Vite, and Pinia.
<br>
<br>
## 🏃‍♀️ Running the Application

To start the application in development mode with hot-reloading, run:

```
npm run dev
```

This will start the Vue application. The Vue application will be available at [localhost:5173](http://localhost:5173).

⚠️ Note: The backend server needs to be running separately for the application to work properly. Please refer to the backend README for instructions on how to set up and run the backend.
<br>
<br>
## 🏗️ Building the Application

To build the application for production, run:

```bash
npm run build
```

This will create a `dist` directory with the compiled and minified assets, ready for deployment.
<br>
<br>
## 📂 Application Structure

The application is structured as follows:

- `src/App.vue`: The root Vue component.
- `src/main.js`: The entry point for the application.
- `src/views/`: Contains the Vue components for the different views in the application.
- `src/components/`: Contains reusable Vue components.
- `src/composables/`: Contains Vue composable functions for interacting with the backend server.
- `src/router/index.js`: Contains the Vue Router configuration.
- `src/stores/`: Contains the Pinia stores used for state management in the application.
