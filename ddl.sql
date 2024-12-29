CREATE DATABASE carsystem;

CREATE TABLE cars(
    Car_ID INT AUTO_INCREMENT PRIMARY KEY,
    plate_id INT UNIQUE not null ,
    brand varchar(100) NOT null,
    model varchar(100) NOT null,
    color varchar(20),
    year YEAR NOT null,
    price float,
    office_id int,
    status ENUM('Active', 'Out of Service', 'Rented') DEFAULT 'Active',
    FOREIGN KEY (office_id) REFERENCES offices(office_id)
);


CREATE TABLE customers(
	customer_id int AUTO_INCREMENT PRIMARY KEY,
    fname varchar(50) NOT null,
    lname varchar(50) not null,
    email varchar(100) not null UNIQUE,
    phone varchar(20) not null,
    address varchar(200) not null,  
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Customer') DEFAULT 'Customer'
);


CREATE TABLE reservations(
    reservation_id int AUTO_INCREMENT not null PRIMARY KEY,
   	car_id int NOT null,
    customer_id int not null,
    reservation_date date not null,
    pickup_date date not null,
    return_date date not null,
    payment_amount decimal(10,2) not null,
    FOREIGN KEY (car_id) REFERENCES cars(Car_id),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);




CREATE TABLE offices(
	office_id int AUTO_INCREMENT PRIMARY key,
    name varchar(50) not null,
    location varchar(100) not null,
    phone varchar(100)


);




CREATE TABLE payments(
	payment_id int AUTO_INCREMENT PRIMARY KEY,
    reservation_id int not null,
    payment_date date not null,
    amount decimal(10,2) not null,
    FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id)
);

