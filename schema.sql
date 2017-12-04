CREATE DATABASE cheapomail;
USE cheapomail;

CREATE TABLE Users(
  id INTEGER,
  firstname TEXT,
  lastname TEXT,
  username TEXT,
  password TEXT
);

CREATE TABLE Messages(
  id INTEGER,
  recipient_ids INTEGER,
  sender_id INTEGER,
  subject TEXT,
  body TEXT,
  date_sent DATE
);

CREATE TABLE Messages_read(
  id INTEGER,
  message_id INTEGER,
  reader_id INTEGER,
  date_read DATE
);

INSERT INTO Users (id, firstname, lastname, username, password) VALUES (1, "Mr", "Admin", "admin", "password123");