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

INSERT INTO departments (name)
VALUES ('HR'),
       ('IT'),
       ('Sales');

INSERT INTO employee (firstName, lastName, departmentId)
VALUES ('John', 'Doe', 1),
       ('Jane', 'Smith', 2),
       ('Michael', 'Johnson', 3),
       ('Emily', 'Wilson', 2),
       ('David', 'Brown', 1),
       ('Sara', 'Garcia', 3),
       ('Daniel', 'Lee', 2),
       ('Maria', 'Martinez', 1),
       ('Robert', 'Johnson', 3),
       ('Jessica', 'Anderson', 2),
       ('William', 'Taylor', 1),
       ('Linda', 'Williams', 3),
       ('Richard', 'Miller', 2);