create database myapp;
use myapp;

create table user(
	id int not null auto_increment primary key,
	fullname varchar(500) not null,
	username varchar(100) not null unique,
	email varchar(255) not null unique,
	password varchar(255) not null,
	created_at datetime not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
---------------------------------------------
create table users_roles(
	id int auto_increment primary key not null, 
	user_id int,
	role_id int,

	CONSTRAINT fkuser_id
		FOREIGN KEY (user_id)
		REFERENCES user (id)
		ON DELETE CASCADE ON UPDATE CASCADE,

	CONSTRAINT fkrole_id
		FOREIGN KEY (role_id)
		REFERENCES roles (id)
		ON DELETE CASCADE ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8;