DROP DATABASE site_php;
CREATE DATABASE site_php;

USE site_php;

CREATE TABLE `user`
(
    id         int PRIMARY KEY AUTO_INCREMENT,
    username   VARCHAR(255) NOT NULL,
    email      VARCHAR(255) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `product`
(
    id          int PRIMARY KEY AUTO_INCREMENT,
    slug        VARCHAR(255) NOT NULL,
    title       VARCHAR(255) NOT NULL,
    description TEXT         NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO user (username, email, password)
VALUES ('Abricot78', 'abri@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK'),
       ('Killer60', 'killer@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK'),
       ('LeGoat', 'legoat@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK'),
       ('JPP80', 'jpp@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK'),
       ('KritoWazabi', 'krito@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK'),
       ('Cr7', 'cr@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK'),
       ('Dell', 'dell@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK'),
       ('RaniLeBG', 'rani@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK'),
       ('AuroreFitness', 'a.fitrness@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK'),
       ('Cristaline', 'crista@gmail.com', '$2y$10$2CTv2LcrLK42K5eKezQDDu0bwhufFYVPCMwsPa/cAI/8wY5JaZLeK');
