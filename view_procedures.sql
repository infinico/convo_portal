CREATE VIEW convo_employee_vw AS
SELECT e.employee_id, e.firstname, e.lastname, e.supervisor_id, p.position_name AS position, CONCAT(s.firstname, ' ', s.lastname) AS supervisor, CONCAT(MONTH(e.hire_date), '-', DAY(e.hire_date), '-', YEAR(e.hire_date)) AS hireDate, CONCAT(MONTH(e.review_date), '-', DAY(e.review_date), '-', YEAR(e.review_date)) AS reviewDate, e.payroll_status, e.hourly_rate, e.employment_status FROM employee s RIGHT JOIN employee e ON e.supervisor_id = s.employee_id LEFT JOIN position_type p ON e.job_code = p.job_code WHERE e.employee_id NOT IN("C001", "C002", "C003")

CREATE VIEW announcement_vw AS
SELECT * FROM announcement

CREATE VIEW position_vw AS
SELECT * FROM position_type ORDER by job_code ASC

CREATE VIEW department_vw AS
SELECT * FROM department ORDER by dept_code ASC

CREATE VIEW location_vw AS
SELECT * FROM location ORDER BY location_code ASC

CREATE VIEW employee_info_vw AS
SELECT e.employee_id, e.firstname, e.lastname, e.job_code, p.position_name, e.street_address, e.city, e.res_state, e.zipcode, e.location_code, l.convo_location, e.supervisor_id, e.payroll_status, e.hourly_rate, e.employment_status FROM employee e LEFT JOIN position_type p ON e.job_code = p.job_code LEFT JOIN location l ON e.location_code = l.location_code ORDER by e.lastname, e.firstname ASC

CREATE VIEW employee_supervisor_vw AS
SELECT DISTINCT e.employee_id, CONCAT(s.lastname, ', ', s.firstname) AS supervisor FROM employee s INNER JOIN employee e ON e.employee_id = s.employee_id ORDER by s.lastname ASC

CREATE VIEW employee_vw AS
SELECT * FROM employee

CREATE VIEW position_db_vw AS
SELECT p.job_code, p.position_name, p.dept_code, d.department_name, p.admin_privilege, p.manager_privilege FROM position_type p LEFT JOIN department d ON p.dept_code = d.dept_code ORDER by job_code ASC


/*INSERT EMPLOYEE HIRE(hire.php) */
CREATE PROCEDURE insert_employee_hire 
(
	IN p_employee_id VARCHAR(4),
	IN p_firstname VARCHAR(255),
	IN p_lastname VARCHAR(255),
    IN p_job_code VARCHAR(6),
    IN p_street_address VARCHAR(255),
    IN p_city VARCHAR(60),
    IN p_res_state CHAR(2),
    IN p_zipcode INT(5),
    IN p_location_code VARCHAR(6),
    IN p_supervisor_id VARCHAR(4),
    IN p_payroll_status ENUM('GBS', 'FT', 'PT'),
    IN p_hourly_rate DECIMAL(10,2),
    IN p_hire_date DATE,
    IN p_updated_at TIMESTAMP,
    IN p_employment_status ENUM('Active', 'Leave', 'Terminated'),
    IN p_active INT(11),
    IN p_password_recover INT(11),
    IN p_date_of_birth DATE,
    IN p_ssn CHAR(4),
    IN p_gender VARCHAR(1)
)
BEGIN

INSERT INTO employee (employee_id, firstname, lastname, job_code, street_address, city, res_state, zipcode, location_code, supervisor_id, payroll_status, hourly_rate, hire_date, updated_at, employment_status, active, password_recover, date_of_birth, ssn, gender) VALUES (p_employee_id, p_firstname, p_lastname, p_job_code, p_street_address, p_city, p_res_state, p_zipcode, p_location_code, p_supervisor_id, p_payroll_status, p_hourly_rate, p_hire_date, p_updated_at, p_employment_status, p_active, p_password_recover, p_date_of_birth, p_ssn, p_gender);

END


/*UPDATE EMPLOYEE INFO (edit.php) */

CREATE PROCEDURE update_employee_info 
(
    IN p_job_code VARCHAR(6),
    IN p_location_code VARCHAR(6),
    IN p_payroll_status ENUM('GBS', 'FT', 'PT'),
    IN p_hourly_rate DECIMAL(10,2),
    IN p_employment_status ENUM('Active', 'Leave', 'Terminated'),
    IN p_supervisor_id VARCHAR(4),
    IN p_updated_at TIMESTAMP,
    IN p_firstname VARCHAR(255),
    IN p_lastname VARCHAR(255),
    IN p_street_address VARCHAR(255),
    IN p_city VARCHAR(60),
    IN p_res_state CHAR(2),
    IN p_zipcode INT(5),
    IN p_employee_id VARCHAR(4)
)
BEGIN

UPDATE employee SET job_code = p_job_code, location_code = p_location_code, payroll_status = p_payroll_status, hourly_rate = p_hourly_rate, employment_status = p_employment_status, supervisor_id=p_supervisor_id, updated_at = p_updated_at, firstname = p_firstname, lastname = p_lastname, street_address=p_street_address, city =p_city, res_state=p_res_state, zipcode=p_zipcode WHERE employee_id = p_employee_id;

END

/*TERMINATE EMPLOYEE (edit.php)*/
CREATE PROCEDURE terminate_employee_info 
(
    IN p_termination_date DATE,
    IN p_termination_reason VARCHAR(1024),
    IN p_employment_status ENUM('Active', 'Leave', 'Terminated'),
    IN p_active INT(11),
    IN p_employee_id VARCHAR(4)
)
BEGIN

UPDATE employee SET termination_date = p_termination_date, termination_reason = p_termination_reason, employment_status = p_employment_status, active = p_active WHERE employee_id = p_employee_id;

END

/*EDIT DB VALUES - Position*/
CREATE PROCEDURE update_position_type 
(
    IN p_position_name VARCHAR(255),
    IN p_dept_code VARCHAR(4),
    IN p_manager_privilege INT(11),
    IN p_admin_privilege INT(11),
    IN p_job_code VARCHAR(6)
)
BEGIN

UPDATE position_type SET position_name = p_position_name, dept_code = p_dept_code, manager_privilege = p_manager_privilege, admin_privilege = p_admin_privilege WHERE job_code = p_job_code;

END

/*EDIT DB VALUES - Department*/
CREATE PROCEDURE update_department 
(
    IN p_dept_code VARCHAR(4),
    IN p_department_name VARCHAR(255)
)
BEGIN

UPDATE department SET department_name = p_department_name WHERE dept_code = p_dept_code;

END

/*EDIT DB VALUES - Location*/
CREATE PROCEDURE update_location 
(
    IN p_location_code VARCHAR(10),
    IN p_convo_location VARCHAR(255),
    IN p_address VARCHAR(255),
    IN p_city VARCHAR(255),
    IN p_state CHAR(2),
    IN p_zip_code CHAR(5)
)
BEGIN

UPDATE location SET convo_location = p_convo_location, address = p_address, city = p_city, state = p_state, zip_code = p_zip_code WHERE location_code = p_location_code;
END

/* INSERT POSITION TYPE DATABASE */
CREATE PROCEDURE insert_position
(
 	IN p_position_name VARCHAR(255),
    IN p_job_code VARCHAR(45),
    IN p_dept_code varchar(15),
    IN p_manager_privilege int(11),
    IN p_admin_privilege int(5)
)
BEGIN
    INSERT INTO position_type (position_name, job_code, dept_code, manager_privilege, admin_privilege) VALUES (p_position_name, p_job_code, p_dept_code, p_manager_privilege, p_admin_privilege);
END

/* INSERT DEPARTMENT DATABASE */
CREATE PROCEDURE insert_department
(
 	IN p_department_name VARCHAR(255),
    IN p_dept_code VARCHAR(45)
)
BEGIN
	INSERT INTO department (department_name, dept_code) VALUES ( p_department_name, p_dept_code);
END

/* INSERT LOCATION DATABASE */
CREATE PROCEDURE insert_location
(
 	IN p_location_code VARCHAR(45),
    IN p_convo_location VARCHAR(255),
    IN p_address VARCHAR(255),
    IN p_city VARCHAR(255),
    IN p_state CHAR(2),
    IN p_zip_code CHAR(5)
)
BEGIN
	INSERT INTO location (location_code, convo_location, address, city, state, zip_code) VALUES (p_location_code, p_convo_location, p_address, p_city, p_state, p_zip_code);
END

/* UPDATE EMAIL */
CREATE PROCEDURE update_email
(
    IN p_employee_id VARCHAR(4),
 	IN p_email VARCHAR(30)
)
BEGIN
	UPDATE employee SET email = p_email WHERE employee_id = p_employee_id;
END

CREATE PROCEDURE search_announcement
(
    IN p_announcement_id INT(1),
    IN p_home_page VARCHAR(4000),
    IN p_effective_date DATETIME
)
BEGIN 
    UPDATE announcement cur, (SELECT * FROM announcement a WHERE a.announcement_id = p_announcement_id) AS fut SET cur.home_page = fut.home_page WHERE fut.effective_date < NOW();
END

CREATE PROCEDURE insert_announcement
(  
    IN p_home_page VARCHAR(4000),
    IN p_effective_date DATETIME
    
)
BEGIN

    IF EXISTS (SELECT DATE(effective_date) FROM announcement WHERE DATE(effective_date) = DATE(p_effective_date)) THEN 
    UPDATE announcement 
    SET home_page = p_home_page, effective_date = p_effective_date 
    WHERE DATE(effective_date) = DATE(p_effective_date);
ELSE 
    INSERT INTO announcement (home_page, effective_date) 
    VALUES (p_home_page, p_effective_date);
END IF;

END

CREATE PROCEDURE insert_log
(
    IN p_employee_id VARCHAR(6),
    IN p_timestamp DATETIME
)
BEGIN
    INSERT INTO log(employee_id, last_visit) VALUES(p_employee_id, p_timestamp);
END

CREATE VIEW log_vw AS
CREATE VIEW log_vw AS
SELECT l.log_id, CONCAT(e.lastname, ", ", e.firstname) AS name, l.convoU_page, l.last_visit FROM log l INNER JOIN employee e ON e.employee_id = l.employee_id ORDER BY last_visit DESC;