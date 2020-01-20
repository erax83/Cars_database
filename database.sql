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
  ('4908280706', 'Albin', 'Asfaltsv 1', '111', '0101111111'),
  ('7005099200', 'Bertil', 'Betongv 2', '222', '0202222222'),
  ('1507303731', 'Ceasar', 'Citronv 3', '333', '0303333333'),
  ('6106064295', 'David', 'Dirigentv 4', '444', '0404444444');
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
  ('AAA111', 'Saab', 'Yellow', '1973', '500', 'Free', NULL ),
  ('BBB222', 'Volvo', 'Red', '2003', '1000', 'Free', NULL ),
  ('CCC333', 'Mustang', 'White', '1983', '3000', '4908280706', '2020-01-05 10:15:26' ),
  ('DDD444', 'Nissan', 'Blue', '1993', '1500', '7005099200', '2020-01-10 10:15:26' );
insert into CarColor (color)
values
  ('Blue'),
  ('White'),
  ('Red'),
  ('Yellow');
insert into CarBrand (brand)
values
  ('Volvo'),
  ('Nissan'),
  ('Saab'),
  ('Mustang');