DROP DATABASE force;

CREATE DATABASE force CHARACTER SET utf8 COLLATE utf8_general_ci;

USE force;

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  name VARCHAR (256) NOT NULL,
  email VARCHAR (256) UNIQUE NOT NULL,
  town_id INT NOT NULL UNSIGNED,
  birthday DATETIME,
  description TEXT,
  pass VARCHAR (256) NOT NULL,
  phone VARCHAR (70) UNIQUE,
  photo VARCHAR (256),
  skype VARCHAR (129) UNIQUE,
  telegram VARCHAR (129) UNIQUE,
  notify_of_messages BOOLEAN,
  notify_of_actions BOOLEAN,
  notify_of_responses BOOLEAN,
  show_contacts BOOLEAN,
  show_profile BOOLEAN
  FOREIGN KEY (town_id) REFERENCES towns (id));

CREATE TABLE job_photos (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  user_id INT UNSIGNED,
  photo VARCHAR (256),
  FOREIGN KEY (user_id) REFERENCES users (id));

CREATE TABLE categories (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  title VARCHAR (256),
  icon VARCHAR (256));

CREATE TABLE users_categories (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  user_id INT UNSIGNED,
  category_id INT UNSIGNED,
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (categories_id) REFERENCES categories (id));

CREATE TABLE tasks (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  user_id INT UNSIGNED,
  title VARCHAR (129) NOT NULL,
  details TEXT,
  category_id INT UNSIGNED,
  town_id INT UNSIGNED,
  budget INT,
  date_start DATETIME,
  date_end DATETIME
  FOREIGN KEY (town_id) REFERENCES towns (id),
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (category_id) REFERENCES categories (id));

CREATE TABLE files (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  task_id INT UNSIGNED,
  path VARCHAR (256),
  FOREIGN KEY (task_id) REFERENCES tasks (id));

CREATE TABLE reviews (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  author_id INT UNSIGNED,
  reviewed_user_id INT UNSIGNED,
  content TEXT,
  rating INT
  FOREIGN KEY (author_id) REFERENCES users (id),
  FOREIGN KEY (reviewed_user_id) REFERENCES categories (id));

CREATE TABLE responds (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  task_id INT UNSIGNED,
  author_id INT UNSIGNED,
  report VARCHAR (512),
  price INT,
  date DATETIME
  FOREIGN KEY (author_id) REFERENCES users (id),
  FOREIGN KEY (task_id) REFERENCES tasks (id));

CREATE TABLE messages (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  author_id INT UNSIGNED,
  text VARCHAR (512)
  FOREIGN KEY (author_id) REFERENCES users (id));

CREATE TABLE towns (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  title VARCHAR (256),
  latitude  FLOAT,
  longitude  FLOAT
);
