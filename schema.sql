CREATE DATABASE IF NOT EXISTS cheapomail;
USE cheapomail;

CREATE TABLE Users(
  id INT AUTO_INCREMENT,
  firstname VARCHAR(32),
  lastname VARCHAR(32),
  username VARCHAR(32),
  password VARCHAR(64),
  PRIMARY KEY(id)
);

CREATE TABLE Messages(
  id INT AUTO_INCREMENT,
  recipient_ids TEXT,
  sender_id INT,
  subject TEXT,
  body TEXT,
  date_sent TEXT,
  PRIMARY KEY(id)
);

CREATE TABLE Messages_read(
  id INT AUTO_INCREMENT,
  message_id INT,
  reader_id INT,
  date_read TEXT,
  PRIMARY KEY(id)
);