CREATE DATABASE IF NOT EXISTS archive_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE archive_management;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255) NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    permission_key VARCHAR(100) NOT NULL UNIQUE,
    label VARCHAR(150) NOT NULL
);

CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id)
);

CREATE TABLE folders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    parent_id INT NULL,
    path VARCHAR(255) NOT NULL UNIQUE,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES folders(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES folders(id)
);

CREATE TABLE folder_permissions (
    role_id INT NOT NULL,
    folder_id INT NOT NULL,
    can_read TINYINT(1) DEFAULT 1,
    can_create TINYINT(1) DEFAULT 0,
    can_update TINYINT(1) DEFAULT 0,
    can_delete TINYINT(1) DEFAULT 0,
    PRIMARY KEY (role_id, folder_id),
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (folder_id) REFERENCES folders(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL
);

CREATE TABLE archives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    folder_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    summary TEXT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (folder_id) REFERENCES folders(id),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE archive_shares (
    archive_id INT NOT NULL,
    user_id INT NOT NULL,
    can_read TINYINT(1) DEFAULT 1,
    can_update TINYINT(1) DEFAULT 0,
    can_delete TINYINT(1) DEFAULT 0,
    shared_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (archive_id, user_id),
    FOREIGN KEY (archive_id) REFERENCES archives(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (shared_by) REFERENCES users(id)
);

CREATE TABLE folder_shares (
    folder_id INT NOT NULL,
    user_id INT NOT NULL,
    can_read TINYINT(1) DEFAULT 1,
    can_create TINYINT(1) DEFAULT 0,
    can_update TINYINT(1) DEFAULT 0,
    can_delete TINYINT(1) DEFAULT 0,
    shared_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (folder_id, user_id),
    FOREIGN KEY (folder_id) REFERENCES folders(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (shared_by) REFERENCES users(id)
);

CREATE TABLE letter_number_formats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    format_pattern VARCHAR(150) NOT NULL COMMENT 'Contoh: {seq}/SK/{dept}/{month}/{year}',
    reset_cycle ENUM('monthly', 'yearly', 'never') DEFAULT 'yearly'
);

CREATE TABLE letter_numbers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    format_id INT NOT NULL,
    sequence_no INT NOT NULL,
    generated_number VARCHAR(150) NOT NULL UNIQUE,
    description VARCHAR(255) NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (format_id) REFERENCES letter_number_formats(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE activity_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action ENUM('CREATE', 'READ', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT') NOT NULL,
    entity_type VARCHAR(100) NOT NULL,
    entity_id INT NOT NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO roles (name, description) VALUES
('Super Admin', 'Akses penuh'),
('Sekretaris', 'Pengelolaan arsip dan penomoran surat');

INSERT INTO permissions (permission_key, label) VALUES
('folder.read', 'Lihat folder'),
('folder.create', 'Buat folder'),
('archive.read', 'Lihat arsip'),
('letter_number.read', 'Lihat penomoran surat'),
('category.read', 'Lihat kategori'),
('activity_log.read', 'Lihat log aktivitas'),
('user.manage', 'Kelola user'),
('share.manage', 'Kelola share file/folder');
('activity_log.read', 'Lihat log aktivitas');

INSERT INTO role_permissions (role_id, permission_id)
SELECT 1, id FROM permissions;

INSERT INTO users (role_id, name, email, password_hash)
VALUES (1, 'Administrator', 'admin@example.com', '$2y$10$mNQXzBgb0W8vA89jVvA4Q.v1IvECOmjoAibc0fBrfEd8w7mnA4wwK');
