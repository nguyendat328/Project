drop database c1904l_project1;
create database c1904l_project1;
use c1904l_project1;


create table c1904l_project1.account(
	id int auto_increment primary key,
    img varchar(500),
    username varchar(255) not null,
    password varchar(40) not null,
    email varchar(255),
    permission varchar(255)
);
create table c1904l_project1.faq(
	id int auto_increment primary key,
    title varchar(500),
    subcontent text,
    answ text
);
create table c1904l_project1.news(
	id int auto_increment primary key,
    img varchar(500),
	title varchar(500),
    title_sign varchar(500),
    subcontent text,
    fullcontent text
);
create table c1904l_project1.food_catalogies(
	id int auto_increment primary key,
    catalogies varchar(255) 
);

create table c1904l_project1.food(
	id int auto_increment primary key,
    img varchar(500),
    title varchar(500),
	title_sign varchar(500),
    subcontent text,
    fullcontent text,
    price float(18,0),
    origin varchar(255),
    id_cat int,
    foreign key(id_cat) references c1904l_project1.food_catalogies(id)
);

create table c1904l_project1.country(
	id int auto_increment primary key,
    countryname varchar(255) unique,
    img varchar(500),
    subcontent text,
    fullcontent text
);
create table c1904l_project1.dogs(
	id int auto_increment primary key,
    img varchar(500),
    dog_name varchar(255),
    subcontent text,
    fullcontent text
);
create table c1904l_project1.dogs_country(
	id_dogs int auto_increment not null,
    id_country int not null,
    foreign key(id_dogs) references c1904l_project1.dogs(id),
    foreign key(id_country) references c1904l_project1.country(id)
);
create table c1904l_project1.catalogies(
    id int auto_increment primary key,
    table_name varchar(255) unique
);
create table c1904l_project1.gallery(
	id int auto_increment primary key,
    img varchar(255),
    caption varchar(1000)
    
);
create table c1904l_project1.album(
id int auto_increment primary key,
album varchar(1000)
);
create table c1904l_project1.gallery_album(
    id_gallery int,
    id_album int ,
    foreign key (id_gallery) references c1904l_project1.gallery(id),
    foreign key(id_album) references c1904l_project1.album(id)
);




