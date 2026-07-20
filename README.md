# 🍔 PrimeBurger - Burger Shop Management System
**Production-Ready | Localhost | PHP + JavaScript + CSS**

A complete, modern burger shop management system built with **vanilla PHP, JavaScript, and CSS** - no frameworks required. Deployed locally on your server.

## 🎯 Business Problems Solved

✅ Slow Inventory Management  
✅ Cost Cutting & Expense Monitoring  
✅ Product Expiration Tracking  
✅ Slow-Moving Item Identification  
✅ Budgeting & Food Costing  
✅ Product Spoilage Monitoring  
✅ Income/Product Shortage Detection  
✅ Customer Service Improvement  

## 📋 Core Modules

1. **Dashboard** - Real-time analytics & KPIs
2. **POS** - Point of Sale with barcode scanning
3. **Inventory** - Stock management & tracking
4. **Expiration Monitoring** - Batch tracking with alerts
5. **Slow-Moving Analytics** - Dead stock identification
6. **Food Costing** - Recipe & budget management
7. **Spoilage Management** - Waste tracking
8. **Shortage Detection** - Inventory reconciliation
9. **Customer Service** - Loyalty & feedback
10. **Supplier Management** - Purchase orders
11. **Sales Reports** - Comprehensive reporting
12. **Employee Management** - User & role management
13. **Notifications** - Real-time alerts

## 🚀 Quick Start

### Prerequisites
- PHP 7.4+
- MySQL 8.0+
- Apache with mod_rewrite

### Installation

1. **Extract to htdocs**
   ```
   C:\xampp\htdocs\primeburger\
   ```

2. **Create database**
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Create database: `primeburger_db`
   - Import: `database/schema.sql`

3. **Configure application**
   ```bash
   cp config/.env.example config/.env
   # Edit config/.env with your database credentials
   ```

4. **Access application**
   ```
   http://localhost/primeburger
   ```

### Default Login
```
Email: admin@primeburger.local
Password: admin123
```

## 📁 Folder Structure

```
primeburger/
├── index.php
├── config/
│   ├── database.php
│   ├── constants.php
│   └── .env.example
├── classes/
│   ├── Database.php
│   ├── User.php
│   ├── Product.php
│   └── ...
├── controllers/
├── api/
├── views/
├── public/
│   ├── css/
│   ├── js/
│   └── uploads/
├── database/
│   └── schema.sql
├── middleware/
├── utils/
└── docs/
```

## 🔐 Security

✅ Bcrypt password hashing  
✅ CSRF protection  
✅ Prepared statements  
✅ Session-based auth  
✅ Role-based access  
✅ Input validation  

## 📖 Documentation

- **[Installation Guide](docs/INSTALLATION.md)**
- **[User Guide](docs/USER_GUIDE.md)**
- **[API Documentation](docs/API.md)**
- **[Database Schema](docs/DATABASE.md)**

## 📞 Support

For issues or questions, check the documentation or review error logs.

---

**Version**: 1.0.0 | **Built**: 2024 | **License**: MIT
