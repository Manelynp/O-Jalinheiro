# 🐔 O Jalinheiro

**O Jalinheiro** is a web application developed to manage and monitor a small poultry farm. The application allows users to manage hens, breeds, egg production, and records of hens that have been removed from the farm.

The project was developed as part of the **IFCD0210 – Web Application Development with Web Technologies** training program, with a focus on **PHP, MySQL, MVC architecture, CRUD operations, and database management**.

## 🌐 Live Demo

**[View O Jalinheiro online](https://manelyn-ojalinheiro.infinityfree.me/)**

> The live version is hosted on InfinityFree.

## ✨ Features

* 🐔 Manage hens
* 🧬 Manage breeds
* 🥚 Register and manage egg production
* 📊 View production statistics
* 📋 Manage records of removed hens
* ➕ Add new records
* ✏️ Modify existing records
* 🗑️ Delete records
* 🔎 Filter egg production by date
* 🗄️ Store and retrieve information from a MySQL database
* 📱 Responsive interface for different screen sizes

## 🛠️ Technologies

* **PHP**
* **MySQL**
* **HTML5**
* **CSS3**
* **JavaScript**
* **MySQLi**
* **MVC architecture**
* **XAMPP**
* **phpMyAdmin**

## 📁 Project Structure

```text
O-Jalinheiro/
│
├── controller/          # Application controllers
│   ├── baja_eliminar.php
│   ├── baja_insertar.php
│   ├── baja_modificar.php
│   ├── gallina_eliminar.php
│   ├── gallina_insertar.php
│   ├── gallina_modificar.php
│   ├── produccion_eliminar.php
│   ├── produccion_filtrar.php
│   ├── produccion_insertar.php
│   ├── raza_eliminar.php
│   ├── raza_insertar.php
│   └── raza_modificar.php
│
├── css/                 # Stylesheets
│   └── style.css
│
├── img/                 # Images and icons
│
├── include/             # Shared PHP files
│   ├── cabecera.php
│   ├── db_connection.php
│   └── pie.php
│
├── js/                  # JavaScript files
│   └── index.js
│
├── model/               # Database and application models
│   ├── baja_model.php
│   ├── estadisticas_model.php
│   ├── gallina_model.php
│   ├── produccion_model.php
│   └── raza_model.php
│
├── sql/                 # Database scripts
│   ├── creacion_BD.sql
│   └── ojalinheiro.sql
│
├── index.php            # Main page
├── bajas.php            # Removed hens management
├── estadisticas.php     # Statistics
├── gallinas.php         # Hens management
├── producciones.php     # Egg production management
└── razas.php            # Breeds management
```

## 🗄️ Database

The application uses a **MySQL** database named:

```text
ojalinheiro
```

The main database entities include:

* **Raza** – stores the different breeds of hens.
* **Gallina** – stores information about the hens.
* **Produccion** – stores egg production records.
* **Baja** – stores records of hens removed from the farm.

SQL scripts for creating and populating the database are included in the `sql/` folder.

## 🚀 Running the Project Locally

### Requirements

* XAMPP
* Apache
* MySQL
* PHP
* phpMyAdmin

### Installation

1. Clone the repository:

```bash
git clone https://github.com/Manelynp/O-Jalinheiro.git
```

2. Copy the project into the XAMPP `htdocs` folder.

3. Start **Apache** and **MySQL** from the XAMPP Control Panel.

4. Open **phpMyAdmin**.

5. Create a database named:

```text
ojalinheiro
```

6. Import the SQL file from:

```text
sql/ojalinheiro.sql
```

7. Check the database connection settings in:

```text
include/db_connection.php
```

8. Open the application in your browser:

```text
http://localhost/O-Jalinheiro/
```

## 📚 Learning Objectives

This project was created to practice the following concepts:

* PHP fundamentals
* Server-side programming
* MySQL database management
* Connecting PHP with MySQL using MySQLi
* CRUD operations
* MVC project organization
* Working with forms and user input
* GET and POST requests
* Data filtering
* Database queries
* Reusable PHP components
* Basic JavaScript interactions
* Responsive web design

## 🎓 Training Project

Developed as part of the:

**IFCD0210 – Desenvolvemento de aplicacións con tecnoloxías web**

The project was created for training purposes to apply PHP, SQL, database access, and web application development concepts.

## 👩‍💻 Author

**Manelyn Paypa**

Junior Web Developer focused on frontend development and currently developing backend skills with PHP and SQL.

* GitHub: [Manelynp](https://github.com/Manelynp)
* LinkedIn: [Manelyn P.](https://www.linkedin.com/in/manelyn-p/)
