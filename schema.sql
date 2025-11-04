CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(70) UNIQUE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) UNIQUE NOT NULL,
    admin_password VARCHAR(255) NOT NULL,
    admin_role ENUM ('admin', 'superAdmin') NOT NULL DEFAULT 'admin',
    admin_status ENUM ('active', 'inactive') NOT NULL DEFAULT 'active',
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sample_image_url VARCHAR(255),
    product_price INT NOT NULL,
    added_by INT NOT NULL,
    display_status ENUM ('visible', 'hidden') NOT NULL DEFAULT 'hidden',
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    report_details TEXT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Users (username, first_name, last_name, email, admin_password, admin_role, admin_status) 
VALUES ('SuperAdmin1', 'Natty', 'Boiiii', 'nattyboiiii@gmail.com', '$2y$10$/1aUjwZxieX54635HsuPaOlmV.ZPxvfbEHKc8WDgHsuyeRm9ifZjG', 'superAdmin', 'active');