create database myapp;
use myapp;

create table user(
	id int auto_increment primary key not null,
	fullname varchar(500) not null,
	username varchar(100) not null unique,
	email varchar(255) not null unique,
	password varchar(255) not null,
	created_at datetime not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--------------------------------------------
CREATE TABLE roles(
	id int not null auto_increment primary key,
	role varchar(100)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
---------------------------------------------
create table user_roles(
	id int auto_increment primary key not null, 
	user_id int,
	role_id int,

	CONSTRAINT fkuser_id
		FOREIGN KEY (user_id)
		REFERENCES user (id)
		ON DELETE CASCADE,

	CONSTRAINT fkrole_id
		FOREIGN KEY (role_id)
		REFERENCES roles (id)
		ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
---------------------------------------------
CREATE TABLE categorias(
	id int auto_increment primary key not null,
	categoria varchar(50)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;