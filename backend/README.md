# ⚙️ Project Planner - Backend

This directory provides the REST API backend for Project Planner, a dynamic project management web application. The backend is built with PHP and uses Docker for containerization. The source code is located in the `app/` subdirectory, which contains various PHP classes for controllers, models, and services.

The backend includes:
* 🌐 NGINX webserver
* 🚀 PHP FastCGI Process Manager with PDO MySQL support
* 🗃️ MariaDB (GPL MySQL fork)
* 📊 PHPMyAdmin
<br>
<br>
## 🛠️ Installation

1. Install Docker Desktop on Windows or Mac, or Docker Engine on Linux.
2. Clone the project
<br>
<br>
## 🚀 Usage

In a terminal, run:
```bash
docker compose up
```

NGINX will now serve files in the app/public folder on [localhost:3000](http://localhost:3000). PHPMyAdmin is accessible on [localhost:8080](http://localhost:8080).

If you want to stop the containers, press Ctrl+C. 
Or run:
```bash
docker compose down
```
