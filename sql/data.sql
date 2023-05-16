DROP
DATABASE if exists company;

CREATE
DATABASE company;

USE
company;

CREATE TABLE departments
(
    id   int primary key auto_increment,
    name varchar(45)
);

CREATE TABLE employee
(
    id           int primary key auto_increment,
    firstName    VARCHAR(44),
    lastName     VARCHAR(44),
    departmentId int,
    foreign key (departmentId) references departments (id)
);

insert into departments
values (NULL, 'admin');

insert into employee
values (NULL, 'AAA', 'AAA', 1);