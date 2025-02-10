# Personal Expense Tracker

## 📌 Overview
The **Personal Expense Tracker** is a web application that helps users manage their finances by tracking income and expenses. It provides a simple and intuitive interface to record transactions, view spending trends, and stay on top of personal finances.

## 🚀 Features
- ✅ **User Registration & Login** (Secure authentication)
- 📊 **Expense & Income Tracking** (Categorize and manage transactions)
- 🔎 **Filter & Search Transactions** (Easily find past records)
- 📈 **Reports & Analytics** (Visual representation of spending trends)
- 💾 **Data Persistence** (Stored securely in a MySQL database)
- 🎨 **Responsive UI** (Built using Bootstrap)

## 🛠️ Tech Stack
- **Frontend:** HTML, CSS, Bootstrap, JavaScript
- **Backend:** PHP (with MySQLi)
- **Database:** MySQL
- **Version Control:** Git

## 📂 Project Structure



## 📌 Setup Instructions

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/yourusername/Personal-Expense-Tracker.git
cd Personal-Expense-Tracker
```
#Ensure you have Apache, MySQL, and PHP installed. If using XAMPP or LAMP stack, start Apache and MySQL.

```bash
mysql -u root -p
```

```sql
CREATE DATABASE dailyexpense;
USE dailyexpense;
```

#Run PersonalExpenseTracker.sql

##Update config.php with your MySQL credentials

```bash
sudo mv Personal-Expense-Tracker /srv/http/
sudo chown -R http:http /srv/http/Personal-Expense-Tracker
sudo chmod -R 755 /srv/http/Personal-Expense-Tracker
sudo systemctl restart httpd
```

## Go to http://localhost/Personal-Expense-Tracker/
