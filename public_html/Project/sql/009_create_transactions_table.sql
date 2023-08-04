CREATE TABLE IF NOT EXISTS Transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_src INT,
    account_dest INT,
    balance_change DECIMAL(10, 2) NOT NULL,
    transaction_type VARCHAR(50),
    memo VARCHAR(255),
    expected_total DECIMAL(10, 2) NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (account_src) REFERENCES Accounts(id),
    FOREIGN KEY (account_dest) REFERENCES Accounts(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
