drop database if exists CARRENTAL;
create database CARRENTAL;
use CARRENTAL;
create table Customers(
  customerID varchar(30),
  customerName varchar(30),
  address varchar(30),
  postalAddress varchar(30),
  phoneNumber varchar(30),
  primary key(customerID)
);
create table Cars(
  regID varchar(30),
  customerID varchar(30),
  make varchar(30),
  color varchar(30),
  prodYear varchar(30),
  price varchar(30),
  checkOutTime datetime,
  primary key(regID)
);
create table RentalHistory(
  regID varchar(30),
  customerID varchar(30),
  checkOutTime varchar(30),
  checkInTime varchar(30),
  days varchar(30),
  cost varchar(30)
);
create table CarColor(color varchar(30), primary key(color));
create table CarBrand(brand varchar(30), primary key(brand));
insert into Customers (
    customerID,
    customerName,
    address,
    postalAddress,
    phoneNumber
  )
values
  ('123', 'Albin', 'Asfaltsv 1', '111', '101'),
  ('456', 'Bertil', 'Asfaltsv 2', '222', '202'),
  ('789', 'Ceasar', 'Asfaltsv 3', '333', '303');
insert into Cars (
    regID,
    make,
    color,
    prodYear,
    price,
    customerID,
    checkOutTime
  )
values
  ('555', 'Saab', 'Yellow', '1973', '6000', 'Free', NULL ),
  ('777', 'Volvo', 'Red', '2003', '5000', 'Free', NULL ),
  ('999', 'Mustang', 'Blue', '1983', '3000', 'Free', '2020-01-05 10:15:26' ),
  ('888', 'Saab', 'Blue', '1993', '2000', '123', '2020-01-10 10:15:26' );
insert into CarColor (color)
values
  ('Blue'),
  ('Red'),
  ('Yellow');
insert into CarBrand (brand)
values
  ('Volvo'),
  ('Saab'),
  ('Mustang');