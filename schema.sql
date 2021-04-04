DROP DATABASE `force`;

CREATE DATABASE `force` CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `force`;

CREATE TABLE cities (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  city VARCHAR (256),
  latitude  FLOAT,
  longitude  FLOAT
);

CREATE TABLE users (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR (256) UNIQUE NOT NULL,
  `name` VARCHAR (256) NOT NULL,
  `password` VARCHAR (256) NOT NULL,
  dt_add DATETIME,
  city_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (city_id) REFERENCES cities (id)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE categories (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR (256),
  icon VARCHAR (256)
);

CREATE TABLE tasks (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  dt_add DATETIME,
  `description` TEXT,
  expire DATETIME,
  `name` VARCHAR (129) NOT NULL,
  `address` VARCHAR (256) NOT NULL,
  budget INT,
  lat FLOAT,
  `long` FLOAT,
  category_id INT UNSIGNED NOT NULL,
  city_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (city_id) REFERENCES cities (id),
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (category_id) REFERENCES categories (id)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE profiles (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  address VARCHAR (256) UNIQUE NOT NULL,
  bd DATETIME,
  about TEXT,
  phone VARCHAR (70) UNIQUE,
  skype VARCHAR (129) UNIQUE,
  user_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users (id)
  ON DELETE CASCADE
  ON UPDATE CASCADE
  -- telegram VARCHAR (129) UNIQUE,
  -- notify_of_messages BOOLEAN,
  -- notify_of_actions BOOLEAN,
  -- notify_of_responses BOOLEAN,
  -- show_contacts BOOLEAN,
  -- show_profile BOOLEAN,
);

CREATE TABLE opinions (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  dt_add DATETIME,
  rate INT,
  `description` TEXT,
  author_id INT UNSIGNED,
  FOREIGN KEY (author_id) REFERENCES users (id)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE replies (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  dt_add DATETIME,
  rate INT,
  `description` TEXT,
  author_id INT UNSIGNED,
  task_id INT UNSIGNED,
  FOREIGN KEY (author_id) REFERENCES users (id),
  FOREIGN KEY (task_id) REFERENCES tasks (id)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

-- CREATE TABLE job_photos (
--   id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
--   user_id INT UNSIGNED,
--   photo VARCHAR (256),
--   FOREIGN KEY (user_id) REFERENCES users (id)
--   ON DELETE CASCADE
--   ON UPDATE CASCADE
-- );

-- CREATE TABLE users_categories (
--   id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
--   user_id INT UNSIGNED,
--   category_id INT UNSIGNED,
--   FOREIGN KEY (user_id) REFERENCES users (id),
--   FOREIGN KEY (category_id) REFERENCES categories (id)
--   ON DELETE CASCADE
--   ON UPDATE CASCADE
-- );

-- CREATE TABLE files (
--   id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
--   task_id INT UNSIGNED,
--   `path` VARCHAR (256),
--   FOREIGN KEY (task_id) REFERENCES tasks (id)
--   ON DELETE CASCADE
--   ON UPDATE CASCADE
-- );

-- CREATE TABLE messages (
--   id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
--   author_id INT UNSIGNED,
--   `text` VARCHAR (512),
--   FOREIGN KEY (author_id) REFERENCES users (id)
--   ON DELETE CASCADE
--   ON UPDATE CASCADE
-- );
