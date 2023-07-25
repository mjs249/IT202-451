INSERT INTO Accounts (id, account, user_id, balance, account_type, created, modified)
VALUES (-1, '000000000000', -1, 0, 'world', NOW(), NOW())
ON DUPLICATE KEY UPDATE account = VALUES(account), user_id = VALUES(user_id), balance = VALUES(balance), account_type = VALUES(account_type), modified = NOW();