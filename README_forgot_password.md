# Forgot Password Implementation

This document explains how the forgot password feature is implemented in the Đoàn Viên Management System.

## Features

- Users can request a password reset from the login page
- System checks if user ID exists and has an associated email
- A unique 6-digit token is generated and sent to the user's email
- Token is valid for 1 hour
- User enters token and new password to complete reset process

## Setup Instructions

### 1. Database Updates

Run the `update_database.sql` script to add the necessary columns to your database:

```sql
-- Add reset password columns to doanvien table
ALTER TABLE doanvien 
ADD COLUMN reset_token VARCHAR(255) NULL,
ADD COLUMN reset_token_expiry DATETIME NULL;

-- Make sure the email column exists
ALTER TABLE doanvien 
ADD COLUMN email VARCHAR(255) NULL;
```

### 2. Email Configuration

The system uses PHPMailer to send emails. Follow these steps to set up email:

1. Download PHPMailer from https://github.com/PHPMailer/PHPMailer and extract it to your project directory as `PHPMailer-master/`

2. Edit the `send-mail.php` file and update the following settings:
   - `$mail->Host`: Your SMTP server (e.g., 'smtp.gmail.com')
   - `$mail->Username`: Your email address
   - `$mail->Password`: Your email password or app password
   - `$mail->setFrom()`: Update with your email and organization name

For Gmail users:
- You may need to create an App Password. Go to your Google Account → Security → App passwords
- Use the generated app password in the configuration

### 3. Testing

To test the password reset functionality:
1. Make sure you have added at least one user with a valid email address
2. Try the "Forgot Password" link from the login page
3. Enter your user ID
4. Check your email for the reset token
5. Enter the token and your new password to complete the process

## Files

- `login.php`: Updated with a link to the reset password page
- `reset-password.php`: Handles the password reset process
- `send-mail.php`: Contains the email sending function using PHPMailer
- `update_database.sql`: SQL script to update the database schema 