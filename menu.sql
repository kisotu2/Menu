CREATE DATABASE menu;

-- Table to store hotel categories
CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
);

-- Table to store hotel information
CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    contact_info VARCHAR(255)
);

-- Table to store food items associated with a hotel
CREATE TABLE food (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    ingredients TEXT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category_id INT,
    hotel_id INT,
    FOREIGN KEY (category_id) REFERENCES items(id),
    FOREIGN KEY (hotel_id) REFERENCES hotels(id)
);

-- Table to store user information
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    id_number VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255),
    hotel_id INT,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id)
);

-- Table to store admin information
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table to store room information associated with a hotel
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_category VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    hotel_id INT,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id)
);
