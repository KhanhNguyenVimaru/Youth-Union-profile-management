-- Add reset password columns to doanvien table
ALTER TABLE doanvien 
ADD COLUMN reset_token VARCHAR(255) NULL,
ADD COLUMN reset_token_expiry DATETIME NULL;

-- Make sure the email column exists
ALTER TABLE doanvien 
ADD COLUMN email VARCHAR(255) NULL; 