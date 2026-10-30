# 📧 Email Automation System (PHP + Gmail SMTP)

A simple email automation system built using PHP, PHPMailer, and MySQL.  
Designed for sending job application emails with tracking, logging, and future follow-up support.

---

## 🚀 Features

- Send emails using Gmail SMTP
- Queue-based sending (1 email per run)
- MySQL-based data storage
- Dynamic email templates
- Logging system (success + failure)
- Google Sheets → Import support
- Duplicate prevention
- Scalable architecture

---

## 📁 Project Structure
email-system/
│── config.php
│── db.php
│── cron.php
│── import.php
│── import-to-db.php
│
├── templates/
│ └── emailTemplates.php
│
├── helpers/
│ └── logger.php
│
├── mailer/
│ └── PHPMailer/
│
└── data/
└── contacts.csv


---

## ⚙️ Setup

### 1. Clone / Upload Project

Upload inside: /public_html/email-system/

---

### 2. Configure Database

Copy `config/db.example.php` to `config/db.local.php` (gitignored) and fill in your credentials,
or set the environment variables `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.

---
3. Create Tables

CREATE TABLE `hr_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `message_id` text DEFAULT NULL,
  `sent_date` datetime DEFAULT NULL,
  `followup_sent` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `attempt_count` int(11) DEFAULT 0,
  `role` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `hr_email_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `response` text DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `error` text DEFAULT NULL,
  `message_id` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_id` (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


4. Gmail SMTP Setup

Use App Password:
Host: smtp.gmail.com
Port: 587
Encryption: TLS

⚠️ Do NOT use your Gmail password. Use App Password.

👨‍💻 Author
Vibhu Tripathi
Full Stack Developer