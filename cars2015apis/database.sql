create database cars2015;

use cars2015;

create table makes
(
	mak_id varchar(5) primary key not null,
	mak_name varchar(50) not null
)engine=innodb;

insert into makes (mak_id, mak_name) values
('1001', 'Ford'),
('1002', 'Honda'),
('1003', 'Nissan');

create table models
(
	mod_id varchar(5) primary key not null,
	mod_name varchar(50) not null,
	mod_id_make varchar(5) not null
)engine=innodb;

insert into models (mod_id, mod_name, mod_id_make) values
('2001', 'Explorer', '1001'),
('2002', 'Focus', '1001'),
('2003', 'Mustang', '1001');
insert into models (mod_id, mod_name, mod_id_make) values
('2004', 'Accord', '1002'),
('2005', 'Civic', '1002'),
('2006', 'CR-V', '1002');
insert into models (mod_id, mod_name, mod_id_make) values
('2007', 'Altima', '1003'),
('2008', 'Maxima', '1003'),
('2009', 'Sentra', '1003');

create table cars
(
	car_id int auto_increment primary key not null,
	car_id_model varchar(5) not null,
	car_year int not null,
	car_price double not null,
	car_color varchar(20) not null,
	car_image varchar(20) null
)engine=innodb;

insert into cars (car_id_model, car_year, car_price, car_color, car_image) values
('2001', 1999, 2400, 'White', '1.jpg'),
('2001', 2002, 2500, 'Metallic Green', '2.jpg'),
('2001', 1996, 3100, 'Gray', '3.jpg'),
('2001', 2004, 3995, 'Red', '4.jpg'),
('2001', 2002, 3999, 'Red', '5.jpg'),
('2001', 2002, 4200, 'Black', '6.jpg'),
('2001', 2007, 4400, 'Oxford White', '7.jpg'),
('2001', 2003, 4977, 'Silver', '8.jpg'),
('2001', 2009, 15999, 'Black', '10.jpg'),
('2001', 2011, 16922, 'Kona Blue Metallic', '11.jpg'),
('2001', 2011, 18250, 'Silver', '12.jpg');
insert into cars (car_id_model, car_year, car_price, car_color, car_image) values
('2002', 1999, 1750, 'White', '13.jpg'),
('2002', 2002, 2500, 'Red', '14.jpg'),
('2002', 2010, 5800, 'Silver', '15.jpg'),
('2002', 2008, 5995, 'Gold', '16.jpg'),
('2002', 2012, 6500, 'Gray', '17.jpg'),
('2002', 2012, 6750, 'Black', '18.jpg'),
('2002', 2014, 7200, 'White', '19.jpg'),
('2002', 2014, 7250, 'White', '20.jpg'),
('2002', 2015, 8900, 'Gray', '21.jpg'),
('2002', 2015, 9100, 'Metallic Gray', '22.jpg'),
('2002', 2013, 9200, 'Red', '23.jpg'),
('2002', 2015, 10250, 'White', '24.jpg');

