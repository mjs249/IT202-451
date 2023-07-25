CREATE TABLE IF NOT EXISTS Transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_src INT NOT NULL,
    account_dest INT NOT NULL,
    balance_change DECIMAL(10, 2) NOT NULL,
    transaction_type VARCHAR(50),
    memo VARCHAR(255),
    expected_total DECIMAL(10, 2) NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (account_src) REFERENCES RM_Accounts(id),
    FOREIGN KEY (account_dest) REFERENCES RM_Accounts(id)
);