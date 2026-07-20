# BSMS Installation Guide

## Prerequisites

- **Server**: Apache with mod_rewrite enabled
- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher
- **Local Server**: XAMPP, WAMP, or LAMP

## Step-by-Step Installation

### 1. Extract Files

Extract the BSMS folder to your htdocs directory:
```
C:\xampp\htdocs\bsms-burger-shop
```

Or on Linux/Mac:
```
/var/www/html/bsms-burger-shop
```

### 2. Create Database

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click **New** to create a new database
3. Database name: `bsms_db`
4. Collation: `utf8mb4_unicode_ci`
5. Click **Create**

### 3. Import Database Schema

1. In phpMyAdmin, select the `bsms_db` database
2. Go to **Import** tab
3. Click **Choose File** and select `database/schema.sql`
4. Click **Import**

### 4. Configure Application

1. Copy the configuration file:
   ```bash
   cp config/.env.example config/.env
   ```

2. Edit `config/.env` and update:
   ```
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=your_password
   DB_NAME=bsms_db
   ```

### 5. Set Permissions

On Linux/Mac, set folder permissions:
```bash
chmod -R 755 bsms-burger-shop
chmod -R 777 public/uploads
```

### 6. Enable mod_rewrite

In Apache configuration (httpd.conf):
```apache
<Directory /path/to/bsms-burger-shop>
    AllowOverride All
    Require all granted
</Directory>
```

Or in XAMPP, ensure `.htaccess` is in the root folder.

### 7. Create Virtual Host (Optional)

In `httpd-vhosts.conf`:
```apache
<VirtualHost *:80>
    ServerName bsms.local
    DocumentRoot "C:/xampp/htdocs/bsms-burger-shop"
    <Directory "C:/xampp/htdocs/bsms-burger-shop">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Add to `hosts` file:
```
127.0.0.1 bsms.local
```

### 8. Test Installation

1. Start Apache and MySQL
2. Access the application:
   - **URL**: `http://localhost/bsms-burger-shop`
   - **Or**: `http://bsms.local` (if virtual host is configured)

3. Default credentials:
   - **Email**: admin@bsms.local
   - **Password**: admin123

## Troubleshooting

### Database Connection Error
- Check MySQL is running
- Verify credentials in `.env`
- Ensure database exists in phpMyAdmin

### Permission Denied Error
- Run: `chmod 755 public/uploads`
- Check Apache user has write permissions

### 404 Errors
- Enable `mod_rewrite` in Apache
- Check `.htaccess` is present
- Verify `AllowOverride All` in Apache config

### Session Issues
- Check PHP session.save_path is writable
- Clear browser cookies
- Check PHP error log

## After Installation

1. **Change Default Password**
   - Login with admin account
   - Go to Settings → Change Password
   - Set a strong password

2. **Create Users**
   - Settings → Users
   - Add users with appropriate roles

3. **Setup Products**
   - Inventory → Products
   - Add your menu items
   - Set prices and costs

4. **Configure Settings**
   - Settings → Business Info
   - Add your shop details
   - Configure currency and language

## Database Backup

Regular backups are important:
```bash
mysqldump -u root -p bsms_db > backup.sql
```

To restore:
```bash
mysql -u root -p bsms_db < backup.sql
```

## Production Deployment

**Important Changes for Production:**

1. Set `APP_ENV=production` in `.env`
2. Disable error output: Set error reporting to log only
3. Use HTTPS (SSL certificate)
4. Change all default passwords
5. Configure firewall rules
6. Setup automated backups
7. Monitor logs regularly
8. Use strong database passwords
9. Restrict file permissions
10. Setup monitoring and alerts

## Support

For issues:
1. Check error logs in `error_log` file
2. Review application logs
3. Check browser console for errors
4. Verify database integrity

---

**Installation Complete!** 🍔

Your BSMS system is ready to use.