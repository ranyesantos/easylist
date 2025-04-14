CREATE DATABASE easy_list;

USE easy_list;

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE product_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    product_id INT,
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

CREATE TABLE color (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

CREATE TABLE picture_color (
    id INT AUTO_INCREMENT PRIMARY KEY,
    picture_url VARCHAR(2083) NOT NULL,
    color_id INT,
    FOREIGN KEY (color_id) REFERENCES color(id) ON DELETE CASCADE
);

CREATE TABLE `size` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    size_description VARCHAR(100) NOT NULL 
);

CREATE TABLE product_size (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quantity INT UNSIGNED NOT NULL DEFAULT 1,
    price INT UNSIGNED NOT NULL,
    stock ENUM('yes', 'no') NOT NULL DEFAULT 'yes',
    product_id INT,
    size_id INT,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE,
    FOREIGN KEY (size_id) REFERENCES `size`(id) ON DELETE CASCADE
);

CREATE TABLE category_size (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE size_category_size (
    id INT AUTO_INCREMENT PRIMARY KEY,
    size_id INT,
    category_size_id INT,
    FOREIGN KEY (size_id) REFERENCES `size`(id) ON DELETE CASCADE,
    FOREIGN KEY (category_size_id) REFERENCES category_size(id) ON DELETE CASCADE
);

CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL
);

CREATE TABLE customer_address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    postal_code VARCHAR(9) NOT NULL,
    street VARCHAR(150) NOT NULL,
    complement VARCHAR(100),
    neighborhood VARCHAR(100),
    city VARCHAR(100) NOT NULL,
    state CHAR(2) NOT NULL,
    customer_id INT,
    FOREIGN KEY (customer_id) REFERENCES customer(id) ON DELETE CASCADE
);

CREATE TABLE customer_order (
    id INT AUTO_INCREMENT PRIMARY KEY,
    delivery_method ENUM('local pickup', 'delivery') NOT NULL DEFAULT 'local pickup',
    remarks TEXT,
    total_price INT NOT NULL,
    customer_id INT,
    FOREIGN KEY (customer_id) REFERENCES customer(id) ON DELETE CASCADE
);

CREATE TABLE product_size_order(
    id INT AUTO_INCREMENT PRIMARY KEY,
    price INT,
    order_id INT,
    product_size_id INT,
    FOREIGN KEY (order_id) REFERENCES customer_order(id) ON DELETE CASCADE,
    FOREIGN KEY (product_size_id) REFERENCES product_size(id) ON DELETE CASCADE
);