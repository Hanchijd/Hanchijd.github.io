drop table if exists users;
create table users(
	username varchar(50) PRIMARY KEY,
	password varchar(100) NOT NULL,
	fullname varchar(100) NOT NULL,
	email VARCHAR(100) NOT NULL);
INSERT INTO users(username,password) VALUES ('admin',md5('1234'));
DROP TABLE IF EXISTS users; 
