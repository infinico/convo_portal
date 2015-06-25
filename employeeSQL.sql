CREATE TABLE employee (
    employeeID VARCHAR(4) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    position_name VARCHAR(255) NOT NULL,
    department_name VARCHAR(255) NOT NULL,
    res_state CHAR(2) NOT NULL,
    convo_location VARCHAR(255) NOT NULL,
    supervisorID VARCHAR(4),
    payroll_status ENUM ("GBS", "FT", "PT"),
    hire_date DATE,
    review_date DATE,
    termination_date DATE,
    termination_reason VARCHAR(1024),
    employment_status ENUM("Active", "Leave", "Terminated"),
    manager_privileges INT DEFAULT 0,
    admin_privileges INT DEFAULT 0,
    active INT DEFAULT 1,
    username VARCHAR(60),
    password VARCHAR(60),
    password_recover INT DEFAULT 0,
    date_of_birth DATE,
    ssn CHAR(4) NOT NULL,
    gender CHAR(1),
    CONSTRAINT employeeID_pk PRIMARY KEY(employeeID),
    CONSTRAINT position_name_fk FOREIGN KEY(position_name) REFERENCES position_type(position_name),
    CONSTRAINT department_name_fk FOREIGN KEY(department_name) REFERENCES department(department_name),
    CONSTRAINT convo_location_fk FOREIGN KEY(convo_Location) REFERENCES location(convo_location)
);

CREATE TABLE position_type (
    position_name VARCHAR(255) NOT NULL,
    CONSTRAINT position_name_pk PRIMARY KEY(position_name)
);

CREATE TABLE department (
    department_name VARCHAR(255) NOT NULL,
    CONSTRAINT department_name_pk PRIMARY KEY(department_name)
);


CREATE TABLE location (
    convo_location VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    city VARCHAR(255),
    state CHAR(2),
    zip_code CHAR(5),
    CONSTRAINT convo_location_pk PRIMARY KEY(convo_Location)
);


CREATE TABLE census (
    dependentID INT NOT NULL AUTO_INCREMENT,
    employeeID VARCHAR(4) NOT NULL,
    firstname VARCHAR(60),
    lastname VARCHAR(60),
    date_of_birth DATE,
    gender VARCHAR(10),
    relationship VARCHAR(60),
    CONSTRAINT dependentID_pk PRIMARY KEY(dependentID),
    CONSTRAINT employeeID_fk FOREIGN KEY(employeeID) REFERENCES employee(employeeID)
);