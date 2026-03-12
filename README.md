# 🦅 Eagle Eye
### Smart Security & Visitor Management System

![PHP](https://img.shields.io/badge/PHP-Backend-blue)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-UI-purple)
![License](https://img.shields.io/badge/License-MIT-green)
![Status](https://img.shields.io/badge/Project-Active-success)

Eagle Eye is a **smart visitor and security management system** designed for residential societies, hostels, or corporate campuses.  
It enables **admins, watchmen, and residents** to efficiently manage visitors, track activities, and communicate in real-time.

The system improves **security, monitoring, and visitor verification** through a centralized dashboard.

---

# 🚀 Features

### 🔐 Authentication
- Secure login system
- Password reset with OTP
- Role-based access (Admin / Watchman / Member)

### 👥 Visitor Management
- Register new visitors
- Capture visitor information
- Track visitor entry & exit

### 🛡 Security Monitoring
- Watchman dashboard
- Visitor verification system
- Activity history logs

### 📊 Admin Dashboard
- Manage members
- Manage watchmen
- Generate reports
- View system analytics

### 💬 Communication
- Real-time chat system
- Admin notifications
- Event announcements

### 📁 Data Tracking
- Visitor history
- Security reports
- Entry/Exit logs

---

# 🖥 Tech Stack

| Technology | Purpose |
|------------|--------|
| PHP | Backend Development |
| MySQL | Database |
| Bootstrap | Frontend UI |
| JavaScript | Dynamic Interaction |
| HTML/CSS | UI Design |
| Composer | Dependency Management |

---
## ⚙️ Setup Instructions

Follow these steps to run **Eagle Eye** on your local machine.

---

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/<your-username>/Eagle_Eye.git
cd Eagle_Eye
```

---

### 2️⃣ Install Required Software

Make sure the following are installed:

* **XAMPP / WAMP / LAMP** (Apache + MySQL + PHP)
* **Composer** (for PHP dependencies)

Download links:

* https://www.apachefriends.org
* https://getcomposer.org

---

### 3️⃣ Move Project to Server Directory

Move the project folder to:

**XAMPP**

```
C:\xampp\htdocs\Eagle_Eye
```

**Linux / Mac**

```
/var/www/html/Eagle_Eye
```

---

### 4️⃣ Install Dependencies

Open terminal inside the project folder and run:

```bash
composer install
```

This will install required PHP packages.

---

### 5️⃣ Import Database

1. Start **Apache** and **MySQL** from XAMPP.
2. Open **phpMyAdmin**
3. Create a new database:

```
eagle_eye
```

4. Import the file:

```
database/127_0_0_1.sql
```

---

### 6️⃣ Configure Database Connection

Open the database configuration file and update credentials:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "eagle_eye";
```

---

### 7️⃣ Run the Project

Open your browser and go to:

```
http://localhost/Eagle_Eye
```

---

## 🔑 Default Login (Example)

Admin:

```
Email: admin@example.com
Password: admin123
```

Watchman:

```
Email: watchman@example.com
Password: watch123
```

*(Change credentials after first login)*

---

## 🧪 Testing the System

Try the following:

* Register a visitor
* Login as admin
* Check visitor logs
* Send chat message
* Create event notification

---

## ❗ Troubleshooting

If the project does not run:

• Ensure **Apache & MySQL are running**
• Check database credentials
• Verify the database was imported correctly
• Run `composer install` again

---

## 📬 Support

If you encounter issues, open an **Issue** in the GitHub repository.
