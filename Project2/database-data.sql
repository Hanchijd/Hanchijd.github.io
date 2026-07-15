 drop table if exists users;
create table users(
	username varchar(50) PRIMARY KEY,
	password varchar(100) NOT NULL);*/
INSERT INTO users(username,password) VALUES ('Hanchijd',md5('Pa$$w0rd'));
