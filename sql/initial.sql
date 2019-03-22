CREATE TABLE `user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `firstName` varchar(100) NOT NULL DEFAULT '',
  `lastName` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(50) NOT NULL DEFAULT '',
  `userStatus` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

CREATE TABLE `order` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `petId` int NOT NULL DEFAULT 0,
  `quantity` smallint NOT NULL DEFAULT 0,
  `shipDate` datetime NULL,
  `status` varchar(100) NOT NULL DEFAULT '',
  `complete` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);

CREATE TABLE `category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);

CREATE TABLE `tag` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `pet` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `categoryId` bigint NOT NULL DEFAULT 0,
  `name` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);

CREATE TABLE `petPhoto` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `petId` bigint NOT NULL DEFAULT 0,
  `url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);

CREATE TABLE `petHasTag` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `petId` bigint NOT NULL DEFAULT 0,
  `tagId` bigint NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `petTag` (`petId`, `tagId`)
);
