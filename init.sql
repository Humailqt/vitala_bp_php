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

CREATE TABLE IF NOT EXISTS task_tables (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL,
  table_name VARCHAR(100) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS devices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vendor VARCHAR(100) NOT NULL,
  model VARCHAR(100) NOT NULL,
  auth_template_id INT,
  FOREIGN KEY (auth_template_id) REFERENCES auth_templates(id) ON DELETE SET NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS subnets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subnet VARCHAR(50) NOT NULL,
  credential_id INT,
  scan_enabled BOOLEAN DEFAULT 1,
  description TEXT,
  FOREIGN KEY (credential_id) REFERENCES credentials(id) ON DELETE SET NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS task_assignments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL,
  node_id INT NOT NULL,
  handler_id INT NOT NULL,
  FOREIGN KEY (task_id) REFERENCES tasks(id),
  FOREIGN KEY (node_id) REFERENCES nodes(id),
  FOREIGN KEY (handler_id) REFERENCES handlers(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO handlers (task_id, name, description) VALUES
(1, 'Backup Cisco SSH', 'Создаёт резервную копию конфигурации Cisco по SSH'),
(1, 'Ping Sweep', 'Проверяет доступность узлов в подсети'),
(1, 'SNMP Inventory', 'Собирает информацию по SNMP'),
(1, 'Check Port Status', 'Проверяет статус портов на коммутаторе'),
(1, 'Simple Echo Task', 'Тестовая задача, возвращает echo hostname');
