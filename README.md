# UPV ORG HUB

*A centralized directory for University of the Philippines Visayas student organizations.*

UPV Org Hub is a web application designed for UPV constituents to explore, discover, and learn more about the various student organizations within the University of the Philippines Visayas. Users can add, edit, delete, or view existing orgs.

> By Julia Contreras and Sam Lansoy

---

## Purpose

The goal of this project is to:

- Provide a centralized directory of UPV organizations
- Help students discover orgs that match their interests
- Make organization information more accessible and organized
- Support engagement within the UPV community

---

## Features

- Browse and view all added organizations
- View detailed information about organizations (Type, Number of Members, Email)

---

## Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/sam-cookie/CMSC129-Lab2-ContrerasJL_LansoySLD
cd CMSC129-Lab2-ContrerasJL_LansoySLD
```

### 2. Install dependencies

```bash
npm install
```

### 3. Environment setup

Copy the `.env.example` file and configure it:

```bash
cp .env.example .env
php artisan key:generate
```

## Database Setup goes here

## Migration commands goes here
 
## Application Preview
| Dashboard | Archived Orgs |
| :---: | :---: |
| <img src="screenshots/dashboard.png" width="750"> | <img src="screenshots/archived.png" width="750"> |

| Search / Filter | Add New Organization |
| :---: | :---: |
| <img src="screenshots/search.png" width="750"> | <img src="screenshots/addorg.png" width="750"> |

| Edit Organization |
| :---: |
| <img src="screenshots/editorg.png" width="750"> |
---

## Features
* **Centralized Directory** – A single hub to browse and discover all registered UPV student organizations.
* **Organization Profiles** – View key details at a glance, including **Organization Type**, **Member Count**, and **Contact Email**.
* **Full CRUD Functionality** – Ability to **Create** new entries, **Read** details, **Update** existing information, and **Delete** organizations from the list.
* **Archive System** – A dedicated "Archived" section to manage and view organizations.
* **Real-time Search** – Integrated search functionality to filter through the list and find specific organizations instantly.

## MVC Architecture & Project Structure

This project follows the **Model-View-Controller (MVC)** design pattern to ensure a clean separation of business logic and views:

### Models (The Data)
Located in `app/Models/`, these files handle the database logic and data structure.
* **`Organization.php`**: The primary model for managing UPV student organization data and attributes.

### Views (The Interface)
Located in `resources/views/`, these define the user interface using Laravel's Blade engine.
* **`orgs/`**: Contains `index.blade.php` (the main directory) and `archived.blade.php` (the archive view).
* **`components/`**: Reusable Blade components like `modal-add-org.blade.php` and `toast.blade.php` to keep the code **DRY (Don't Repeat Yourself)**.
* **`layouts/`**: The master `app.blade.php` file providing a consistent structure across all pages.

### Controllers (The Logic)
Located in `app/Http/Controllers/`.
* **`OrgController.php`**: The "brain" of the app, managing data flow between the models and views, including search, storage, and update logic.

Here is the structured project layout:

```text
UPV-Org-Hub/
├── app/
│   ├── Http/
│   │   └── Controllers/      # OrgController.php (C in MVC)
│   └── Models/               # Organization.php (M in MVC)
├── database/
│   ├── migrations/           # Database table definitions
│   └── seeders/              # OrganizationSeeder.php for sample data
├── public/                   # Compiled assets (CSS/JS)
├── resources/
│   └── views/                # (V in MVC)
│       ├── components/       # Reusable Modals and Toasts
│       ├── layouts/          # Master app layout
│       └── orgs/             # index and archived Blade templates
├── routes/
│   └── web.php               # Application routes
├── screenshots/              # Project documentation images
├── .env                      # Environment configuration (Private)
└── README.md                 # Project documentation