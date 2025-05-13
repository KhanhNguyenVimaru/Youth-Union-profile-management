-- Add reset password columns to doanvien table
ALTER TABLE doanvien 
ADD COLUMN reset_token VARCHAR(255) NULL,
ADD COLUMN reset_token_expiry DATETIME NULL;