CREATE TABLE IF NOT EXISTS RM_Accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account VARCHAR(12) UNIQUE NOT NULL,
    user_id INT,
    balance INT DEFAULT 0,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CHECK (balance >= 0 AND LENGTH(account) = 12)
);
