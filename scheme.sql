CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE cities (
  id int PRIMARY KEY AUTO_INCREMENT,
  name varchar(30) NOT NULL
);

CREATE TABLE categories (
  id int PRIMARY KEY AUTO_INCREMENT,
  name varchar(40) NOT NULL
);

CREATE TABLE `statuses` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(20)
);

CREATE TABLE `actions` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(20)
);

CREATE TABLE `roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(20)
);

CREATE TABLE users (
  id int PRIMARY KEY AUTO_INCREMENT,
  email varchar(40) NOT NULL,
  name varchar(30) NOT NULL,
  citi_id int NOT NULL,
  password varchar(64) NOT NULL,
  address varchar(255),
  latitude float,
  longitude float,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  avatar_path varchar(255),
  date_birth date,
  about_itself text,
  last_activity datetime,
  popularity int,
  `role_id` int NOT NULL,
  FOREIGN KEY (citi_id) REFERENCES cities (id) ON UPDATE CASCADE,
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  UNIQUE INDEX (email),
  INDEX (id),
  INDEX (name),
  INDEX (citi_id)
);

CREATE TABLE tasks (
  id int PRIMARY KEY AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  description text NOT NULL,
  location varchar(255),
  citi_id int,
  latitude float,
  longitude float,
  owner_id int NOT NULL,
  doer_id int,
  expires_at datetime,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  status_id int NOT NULL,
  category_id int NOT NULL,
  FOREIGN KEY (citi_id) REFERENCES cities (id) ON UPDATE CASCADE,
  FOREIGN KEY (owner_id) REFERENCES users (id) ON UPDATE CASCADE,
  FOREIGN KEY (doer_id) REFERENCES users (id) ON UPDATE CASCADE,
  FOREIGN KEY (status_id) REFERENCES statuses (id)ON UPDATE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE CASCADE,
  INDEX (id),
  INDEX (title),
  INDEX (citi_id),
  INDEX (expires_at),
  INDEX (status_id),
  INDEX (category_id)
);


CREATE TABLE users_specializations (
  id int PRIMARY KEY AUTO_INCREMENT,
  user_id int NOT NULL,
  category_id int NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE CASCADE
);

CREATE TABLE responses (
  id int PRIMARY KEY AUTO_INCREMENT,
  task_id int NOT NULL,
  user_id int NOT NULL,
  message text NOT NULL,
  price int NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  is_refused tinyint(1),
  FOREIGN KEY (task_id) REFERENCES tasks (id) ON UPDATE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE,
  INDEX (task_id)
);


CREATE TABLE rates (
  id int PRIMARY KEY AUTO_INCREMENT,
  task_id int NOT NULL,
  user_id int NOT NULL,
  comment text,
  rate tinyint(5),
  ready_status tinyint(1),
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (task_id) REFERENCES tasks (id) ON UPDATE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE,
  INDEX (user_id)
);

CREATE TABLE messages (
  id int PRIMARY KEY AUTO_INCREMENT,
  task_id int NOT NULL,
  from_user_id int NOT NULL,
  to_user_id int NOT NULL,
  message text NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (task_id) REFERENCES tasks (id) ON UPDATE CASCADE,
  FOREIGN KEY (from_user_id) REFERENCES users (id) ON UPDATE CASCADE,
  FOREIGN KEY (to_user_id) REFERENCES users (id) ON UPDATE CASCADE,
  INDEX (task_id),
  INDEX (from_user_id),
  INDEX (to_user_id)
);

CREATE TABLE `tasks_files` (
  id int PRIMARY KEY AUTO_INCREMENT,
  task_id int NOT NULL,
  img_path varchar(255) NOT NULL,
  FOREIGN KEY (task_id) REFERENCES tasks (id),
  INDEX (task_id)
);

CREATE TABLE favorites (
  id int PRIMARY KEY AUTO_INCREMENT,
  user_id int NOT NULL,
  fovorite_profile_id int NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE,
  FOREIGN KEY (fovorite_profile_id) REFERENCES users (id) ON UPDATE CASCADE,
  INDEX (user_id)
);

CREATE TABLE `users_contacts` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `phone` varchar(20),
  `skype` varchar(30),
  `other` varchar(100),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  INDEX (`user_id`)
);

CREATE TABLE `users_avatars` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `path` varchar(255) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  INDEX (`user_id`)
);

CREATE TABLE `users_notifications_types` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100)
);

CREATE TABLE `users_notifications_settings` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `notification_type_id` int NOT NULL,
  `value` boolean,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  FOREIGN KEY (`notification_type_id`) REFERENCES `users_notifications_types` (`id`) ON UPDATE CASCADE,
  INDEX (`user_id`)
);

CREATE TABLE `users_visibility_settings` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `show_profile` boolean,
  `show_contacts` boolean,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  INDEX (`user_id`)
);

CREATE TABLE `users_works_images` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `path` varchar(255),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  INDEX (`user_id`)
);
