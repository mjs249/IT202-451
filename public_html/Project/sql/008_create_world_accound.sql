INSERT INTO Accounts (id, account_number, user_id, balance, created, modified)
VALUES (-1, '000000000000', -1, 0, NOW(), NOW())
ON DUPLICATE KEY UPDATE account_number = VALUES(account_number), user_id = VALUES(user_id), balance = VALUES(balance), modified = NOW();