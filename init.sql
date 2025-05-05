CREATE DATABASE IF NOT EXISTS vitala CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE vitala;


CREATE TABLE IF NOT EXISTS nodes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ip VARCHAR(45) NOT NULL,
  subnet VARCHAR(45),
  mac VARCHAR(32),
  hostname VARCHAR(100),
  location VARCHAR(100),
  description TEXT,
  device VARCHAR(100),
  credentials_id INT DEFAULT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO nodes (ip, subnet, mac, hostname, location, description, device) VALUES
('192.168.1.10', '192.168.1.0/24', '00:11:22:33:44:55', 'node-1', 'Moscow', 'test node', 'Router'),
('192.168.1.11', '192.168.1.0/24', '00:11:22:33:44:66', 'node-2', 'Piter', 'camera test', 'Camera');

CREATE TABLE IF NOT EXISTS auth_templates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  sequence TEXT NOT NULL,
  credentials_id INT DEFAULT NULL,
  description TEXT
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS credentials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  telnet_login VARCHAR(100),
  telnet_password VARCHAR(100),
  enable_password VARCHAR(100),
  ssh_login VARCHAR(100),
  ssh_password VARCHAR(100)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  task_type VARCHAR(50),
  description TEXT,
  result_table VARCHAR(100),
  has_nodes BOOLEAN DEFAULT 0,
  has_devices BOOLEAN DEFAULT 0
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS handlers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  description TEXT
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS schedules (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL,
  cron_expression VARCHAR(100) NOT NULL,
  enabled BOOLEAN DEFAULT 1
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
