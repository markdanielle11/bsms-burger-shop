# 🚀 HOW TO RUN BSMS - Step by Step Guide

Complete instructions to run the Burger Shop Management System on your local computer.

---

## 📋 Prerequisites (Install These First)

### Option 1: Using XAMPP (Recommended - Easiest)

1. **Download XAMPP**
   - Go to: https://www.apachefriends.org
   - Download XAMPP for your operating system (Windows/Mac/Linux)
   - Version: PHP 7.4 or higher

2. **Install XAMPP**
   - Windows: Run the installer, choose `C:\xampp\` as installation folder
   - Mac: Run installer (requires admin password)
   - Linux: Extract to `/opt/xampp`

3. **Start XAMPP**
   - Windows: Open `C:\xampp\xampp-control-panel.exe`
   - Mac/Linux: Open terminal and run `/opt/lampp/xampp start`

4. **Check Status**
   - Click "Start" next to Apache and MySQL
   - Both should show "Running" (green)

---

## ⬇️ Step 1: Download/Clone the Project

### **Option A: Using Git (Recommended)**

If you have Git installed:

```bash
# Open Command Prompt / Terminal / PowerShell

# Navigate to htdocs folder
cd C:\xampp\htdocs

# Clone the repository
git clone https://github.com/markdanielle11/bsms-burger-shop.git

# Go into the folder
cd bsms-burger-shop
```

### **Option B: Download as ZIP**

1. Go to: https://github.com/markdanielle11/bsms-burger-shop
2. Click **Code** button (green)
3. Click **Download ZIP**
4. Extract the ZIP to `C:\xampp\htdocs\`
5. Rename folder to `bsms-burger-shop`

---

## 🗄️ Step 2: Create Database

### **Using phpMyAdmin (Easy GUI)**

1. **Open phpMyAdmin**
   - Go to: http://localhost/phpmyadmin
   - Username: `root`
   - Password: (leave empty)
   - Click **Go**

2. **Create New Database**
   - Left sidebar, click **New**
   - Database name: `bsms_db`
   - Collation: `utf8mb4_unicode_ci`
   - Click **Create**

3. **Import Database Schema**
   - Click the newly created `bsms_db` database
   - Go to **Import** tab
   - Click **Choose File**
   - Select: `bsms-burger-shop/database/schema.sql`
   - Click **Import**
   - Wait for success message ✅

### **Using Command Line (Alternative)**

```bash
# Open Command Prompt as Administrator

# Navigate to MySQL folder
cd C:\xampp\mysql\bin

# Create database
mysql -u root < path/to/bsms-burger-shop/database/schema.sql

# If that doesn't work, try:
mysql -u root
CREATE DATABASE bsms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Then import schema
mysql -u root bsms_db < path/to/bsms-burger-shop/database/schema.sql
```

---

## ⚙️ Step 3: Configure Environment

### **Edit Configuration File**

1. **Navigate to config folder**
   ```
   C:\xampp\htdocs\bsms-burger-shop\config\
   ```

2. **Copy .env file**
   - Find: `.env.example`
   - Copy and rename to: `.env`

3. **Edit .env file**
   - Right-click `.env`
   - Open with Notepad or VSCode
   - Change these lines:

   ```ini
   # Database
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=
   DB_NAME=bsms_db
   
   # Application
   APP_URL=http://localhost/bsms-burger-shop
   ```

4. **Save the file** (Ctrl+S)

---

## 🔓 Step 4: Set Folder Permissions (Windows Only)

If you get "Permission Denied" errors:

1. Right-click `bsms-burger-shop` folder
2. Properties → Security → Edit
3. Select your user
4. Check all boxes
5. Click OK

Or right-click `public/uploads` folder → Properties → Sharing → Share

---

## ✅ Step 5: Verify Apache Configuration

### **Check .htaccess Support**

1. Open XAMPP Control Panel
2. Click **Config** next to Apache
3. Click **Apache (httpd.conf)**
4. Find the section with `<Directory "C:/xampp/htdocs">`
5. Look for this line:
   ```apache
   AllowOverride All
   ```
   - If it says `AllowOverride None` → Change to `AllowOverride All`
6. Save the file
7. Restart Apache

---

## 🌐 Step 6: Run the Application

### **Start the Services**

1. **Open XAMPP Control Panel**
2. Click **Start** next to:
   - ✅ Apache
   - ✅ MySQL
3. Wait for both to show "Running" (green)

### **Access the Application**

Open your web browser and go to:

```
http://localhost/bsms-burger-shop
```

Or if you configured a virtual host:

```
http://bsms.local
```

---

## 🔐 Step 7: Login

**Default Credentials:**

```
Email:    admin@bsms.local
Password: admin123
```

✅ You should now see the Dashboard!

---

## 🛠️ Using PHP Built-in Server (Alternative)

If XAMPP is too heavy, use PHP's built-in server:

```bash
# Open Command Prompt/Terminal
# Navigate to project folder
cd C:\xampp\htdocs\bsms-burger-shop

# Start PHP server
php -S localhost:8000

# Access in browser
# http://localhost:8000
```

⚠️ Note: You still need MySQL running in XAMPP

---

## 🐛 Troubleshooting

### **Problem: "This page isn't available"**
- ❌ Apache is not running
- ✅ Click "Start" in XAMPP for Apache

### **Problem: "Database Connection Error"**
- ❌ MySQL is not running OR database not created
- ✅ Start MySQL in XAMPP
- ✅ Verify database was imported

### **Problem: "404 Not Found"**
- ❌ mod_rewrite not enabled
- ✅ Enable `AllowOverride All` in Apache config
- ✅ Restart Apache

### **Problem: "Permission Denied on uploads"**
- ❌ Folder permissions issue
- ✅ Right-click `public/uploads` → Properties → Security → Edit
- ✅ Grant full permissions

### **Problem: Login page shows but can't login**
- ❌ Check email and password (case-sensitive)
- ✅ Default is: `admin@bsms.local` / `admin123`
- ✅ Clear browser cookies and try again

### **Problem: Blank white page**
- ❌ PHP error occurred
- ✅ Check error log: `C:\xampp\apache\logs\error.log`
- ✅ Open browser console (F12) to see errors

### **Problem: "Port 80 already in use"**
- ❌ Another service using port 80
- ✅ Change Apache port in XAMPP config
- ✅ Or close the conflicting application

---

## 📁 Project Structure After Installation

```
C:\xampp\htdocs\bsms-burger-shop\
├── index.php              ← Main entry point
├── config/
│   ├── .env              ← Your configuration
│   ├── .env.example      ← Template
│   ├── database.php
│   └── constants.php
├── classes/              ← PHP Classes
│   ├── Database.php
│   ├── User.php
│   ├── Product.php
│   └── Inventory.php
├── controllers/          ← Business logic
│   ├── AuthController.php
│   └── DashboardController.php
├── api/                  ← API endpoints
│   └── dashboard.php
├── views/                ← HTML pages
│   ├── login.php
│   ├── dashboard.php
│   └── layout/
├── public/               ← Web accessible
│   ├── css/
│   │   ├── style.css
│   │   └── responsive.css
│   ├── js/
│   │   └── main.js
│   └── uploads/         ← User uploads
├── database/
│   └── schema.sql       ← Database structure
├── middleware/          ← Security middleware
└── .htaccess           ← URL routing
```

---

## 🔄 Workflow After Installation

### **First Time**
1. ✅ Start XAMPP (Apache + MySQL)
2. ✅ Go to http://localhost/bsms-burger-shop
3. ✅ Login with admin account
4. ✅ System is ready to use!

### **Next Day**
1. Start XAMPP
2. Access the application
3. Start using the system

### **Stop XAMPP**
1. Open XAMPP Control Panel
2. Click **Stop** for Apache and MySQL
3. Close XAMPP

---

## 💻 Creating Your First Admin Account

After login:

1. Go to **Settings** (if available)
2. Click **Users** or **Employees**
3. Click **Add User**
4. Enter:
   - Name
   - Email
   - Password
   - Role: Administrator
5. Click **Create**

---

## 🔑 Changing Default Password

1. Login with `admin@bsms.local` / `admin123`
2. Click your name (top right) → **Settings**
3. Click **Change Password**
4. Enter:
   - Current: `admin123`
   - New: (your new password)
   - Confirm: (repeat new password)
5. Click **Update**

---

## 📞 Common Commands

### **Stop and Start Services**

```bash
# Windows Command Prompt

# Stop MySQL
net stop MySQL80

# Start MySQL
net start MySQL80

# Stop Apache
net stop Apache2.4

# Start Apache
net start Apache2.4
```

### **Reset to Fresh State**

```bash
# Delete and recreate database
mysql -u root -e "DROP DATABASE bsms_db;"
mysql -u root -e "CREATE DATABASE bsms_db CHARACTER SET utf8mb4;"
mysql -u root bsms_db < path/to/schema.sql
```

---

## 📊 Accessing Database Directly

**phpMyAdmin** (Easy GUI):
```
http://localhost/phpmyadmin
```

**MySQL Command Line**:
```bash
mysql -u root -p
# When prompted for password, press Enter (no password)
USE bsms_db;
SHOW TABLES;
```

---

## 🌟 Tips & Tricks

1. **Keep XAMPP running** while developing
2. **Regular backups**: Backup `bsms_db` database weekly
3. **Check error logs** if something breaks
4. **Use phpMyAdmin** to verify data
5. **Test in Chrome/Firefox** for compatibility

---

## ✨ You're All Set!

The BSMS system is now running on your local machine. 

**Start with:**
- 📊 Dashboard - See real-time analytics
- 💳 POS - Process sales
- 📦 Inventory - Manage stock

---

**Need Help?**
- Check error logs: `C:\xampp\apache\logs\error.log`
- Review `.env` configuration
- Make sure both Apache AND MySQL are running
- Clear browser cache (Ctrl+Shift+Delete)

🍔 **Enjoy using BSMS!**

