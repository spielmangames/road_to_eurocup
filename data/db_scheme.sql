CREATE TABLE `player` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `born` INT(4) NOT NULL,
  `transfermarkt` VARCHAR(255) NOT NULL,
  `classic` BOOLEAN NOT NULL,
  `enabled` BOOLEAN NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`name`)
);

CREATE TABLE `team` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `enabled` BOOLEAN NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`name`)
);

CREATE TABLE `player__team` (
  `player_id` INT NOT NULL,
  `team_id` INT NOT NULL,
  UNIQUE KEY (`player_id`, `team_id`),
  FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `perk` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dice` INT(2) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`dice`)
);

CREATE TABLE `perk_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `perk_type__perk` (
  `perk_id` INT NOT NULL,
  `perk_type_id` INT NOT NULL,
  UNIQUE KEY (`perk_id`, `perk_type_id`),
  FOREIGN KEY (`perk_id`) REFERENCES `perk` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`perk_type_id`) REFERENCES `perk_type` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `perk_result` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(255),
  `note` VARCHAR(255),
  PRIMARY KEY (`id`)
);

CREATE TABLE `perk_result__perk` (
  `perk_id` INT NOT NULL,
  `perk_result_id` INT NOT NULL,
  UNIQUE KEY (`perk_id`, `perk_result_id`),
  FOREIGN KEY (`perk_id`) REFERENCES `perk` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`perk_result_id`) REFERENCES `perk_result` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `perk__player` (
  `perk_id` INT NOT NULL,
  `player_id` INT NOT NULL,
  UNIQUE KEY (`perk_id`, `player_id`),
  FOREIGN KEY (`perk_id`) REFERENCES `perk` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `position` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(2) NOT NULL,
  `description` VARCHAR(255),
  PRIMARY KEY (`id`),
  UNIQUE KEY (`name`)
);

CREATE TABLE `position__player` (
  `player_id` INT NOT NULL,
  `position_id` INT NOT NULL,
  `attack` INT NOT NULL DEFAULT 0,
  `defence` INT NOT NULL DEFAULT 0,
  UNIQUE KEY (`player_id`, `position_id`),
  FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `tactical_setting` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `result` VARCHAR(255),
  `note` VARCHAR(255),
  PRIMARY KEY (`id`)
);

CREATE TABLE `tactical_setting_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `tactical_setting_type__tactical_setting` (
  `tactical_setting_id` INT NOT NULL,
  `tactical_setting_type_id` INT NOT NULL,
  UNIQUE KEY (`tactical_setting_id`, `tactical_setting_type_id`),
  FOREIGN KEY (`tactical_setting_id`) REFERENCES `tactical_setting` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`tactical_setting_type_id`) REFERENCES `tactical_setting_type` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);
