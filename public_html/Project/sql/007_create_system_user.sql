INSERT INTO Users (id, username, password, email, created, modified)
VALUES (-1, 'system_user', 'system_password', 'system@example.com', NOW(), NOW())
ON DUPLICATE KEY UPDATE username = VALUES(username), password = VALUES(password), email = VALUES(email), modified = NOW();