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

CREATE TABLE roles(
	id int not null auto_increment primary key,
	role varchar(100)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE session(
	id int not null auto_increment primary key,
	username varchar(100) not null,
	is_active boolean not null,
	last_activity datetime not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE session ADD INDEX(username);
CREATE TABLE data_trace(
	id int AUTO_INCREMENT PRIMARY key not null, 
    username varchar(100) not null,
    _before varchar(150) not null, 
    _after varchar(150) not null,
    _date datetime not null
)ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE categorias(
	id int auto_increment primary key not null,
	categoria varchar(50) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE tickets(
	id int auto_increment primary key not null,
	nombre varchar(30) not null,
	apellido varchar(30) not null,
	email varchar(50) not null,
	ticket varchar(500) not null,
	consulta varchar(255) not null,
	created_at timestamp not null,
	updated_at timestamp not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE data_sales(
	id_compra int primary key AUTO_INCREMENT not null,
    titulo varchar(300) not null, 
    image text,
    descripcion varchar(300),
    precio float not null,
    username varchar(30) not null,
    fechacompra date not null,
    cantidad int not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE orders(
	id_orden varchar(50) not null,
	id_item int auto_increment primary key not null,
	id_prod int not null,

	constraint fk_id_prod_order
	foreign key (id_prod)
	references data_sales (id_compra)
	on delete cascade
	on update cascade,

	cantidad int not null,
    username varchar(30) not null,
    fechacompra date not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE receipt(
	id int auto_increment primary key not null,
    monto float not null,
    username varchar(30) not null,
    fechacompra timestamp not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE receipt_list(
	id_receipt int not null,
	id_prod int not null,

	constraint fk_id_receipt_receipt
	foreign key (id_receipt)
	references receipt (id)
	on delete cascade
	on update cascade,

	constraint fk_id_prod_receipt
	foreign key (id_prod)
	references data_sales (id_compra)
	on delete cascade
	on update cascade,

    precio float not null, 
    cantidad int not null,
    username varchar(30) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO roles(id,role) VALUES (1, 'admin');
INSERT INTO roles(id,role) VALUES (2, 'customer');
INSERT INTO roles(id,role) VALUES (3, 'supervisor');
INSERT INTO roles(id,role) VALUES (4, 'hardware_specialist');
INSERT INTO roles(id,role) VALUES (5, 'software_specialist');
INSERT INTO roles(id,role) VALUES (6, 'admin_compra');

INSERT INTO user(fullname,username,email,password,created_at) VALUES ('main admin','admin','admin@email.com','12345',NOW());
INSERT INTO user_roles(user_id,role_id) VALUES(1,1);
INSERT INTO user_roles(user_id,role_id) VALUES(1,6);