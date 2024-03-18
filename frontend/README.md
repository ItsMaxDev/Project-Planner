# Vue 3 frontend

This is the frontend part of my Web Development 2 project.
<br>
<br>

## 🛠️ Project Setup

⚠️ Before you start, make sure you have [Node.js](https://nodejs.org/) installed on your machine. Node.js is required to run `npm` commands. 

First, open a terminal in the project directory. Then, install the project dependencies:

```bash
npm install
```

This will install all the necessary packages for the project, including Vue, Vite, and json-server.
<br>
<br>
## 🏃‍♀️ Running the Application

To start the application in development mode with hot-reloading and a mock backend server, run:

```
npm run dev
```

This will start both the Vue application and a `json-server` instance. The Vue application will be available at `http://localhost:5173`, and the `json-server` backend will be available at `http://localhost:3000`.
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
## 🕵️‍♀️ Previewing the Production Build

To serve the production build of the application over a local server, run:

```bash
npm run preview
```

This allows you to preview the production build before deploying it.
<br>
<br>
## 📂 Application Structure

The application is structured as follows:

- `src/App.vue`: The root Vue component.
- `src/main.js`: The entry point for the application.
- `src/views/`: Contains the Vue components for the different views in the application.
- `src/components/`: Contains reusable Vue components.
- `src/composables/`: Contains Vue composable functions for interacting with the backend server.
- `data/db.json`: The mock database file for json-server.
<br>

## 💻 Recommended IDE Setup

For the best development experience, I recommend using [VSCode](https://code.visualstudio.com/) with the [Volar](https://marketplace.visualstudio.com/items?itemName=johnsoncodehk.volar) extension (and disable Vetur).
