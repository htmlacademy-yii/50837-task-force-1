CREATE DATABASE forse CHARACTER SET utf8 COLLATE utf8_general_ci;

USE forse;

CREATE TABLE users (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR (70) NOT NULL,
  email VARCHAR (129) UNIQUE NOT NULL,
  city VARCHAR (129) NOT NULL,
  birthday DATETIME,
  discription VARCHAR (256),
  pass VARCHAR (256) NOT NULL,
  phone INT UNSIGNED,
  photo VARCHAR (256),
  skype VARCHAR (129) UNIQUE,
  telegram VARCHAR (129) UNIQUE,
  notify_of_messages BOOLEAN,
  notify_of_actions BOOLEAN,
  notify_of_responses BOOLEAN,
  show_contacts BOOLEAN,
  not_show_profile BOOLEAN);

CREATE TABLE job_photos (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  photo VARCHAR (256),
  FOREIGN KEY (user_id) REFERENCES users (id));

CREATE TABLE categories (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  title VARCHAR (128));

CREATE TABLE users_of_categories (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  categories_id INT,
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (categories_id) REFERENCES categories (id));

CREATE TABLE tasks (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  iNeed VARCHAR (129) NOT NULL,
  job_details VARCHAR (512),
  categories_id INT,
  adress VARCHAR (256),
  budget INT,
  date_start DATETIME,
  date_end DATETIME);

CREATE TABLE files (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  task_id INT,
  document VARCHAR (256),
  FOREIGN KEY (task_id) REFERENCES tasks (id));

CREATE TABLE reviews (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  author_review_id INT,
  user_id INT,
  review VARCHAR (512),
  rating INT);

CREATE TABLE responds (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  task_id INT,
  author_id INT,
  report VARCHAR (512),
  price INT,
  data_respond DATETIME);

CREATE TABLE messages (
  id INT PRIMARY KEY AUTO_INCREMENT UNSIGNED,
  author_id INT,
  user_id INt,
  report VARCHAR (512));
