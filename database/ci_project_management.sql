-- -----------------------------------------------------
-- DATABASE: ci_project_management
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS ci_project_management
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE ci_project_management;

-- -----------------------------------------------------
-- TABLE: company
-- -----------------------------------------------------
CREATE TABLE company (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    website VARCHAR(255)
);

-- -----------------------------------------------------
-- TABLE: company_locations
-- -----------------------------------------------------
CREATE TABLE company_locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    address VARCHAR(255),
    unit VARCHAR(50),
    postal_code VARCHAR(30),
    country VARCHAR(100),
    region VARCHAR(100),
    city VARCHAR(100),
    phone VARCHAR(30),
    email VARCHAR(255),
    CONSTRAINT fk_company_locations_company_id
    FOREIGN KEY (company_id) REFERENCES company(id)
);

-- -----------------------------------------------------
-- TABLE: contact
-- -----------------------------------------------------
CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    company_location_id INT,
    first_name VARCHAR(150) NOT NULL,
    last_name VARCHAR(150) NOT NULL,
    job_title VARCHAR(100),
    phone VARCHAR(30),
    email VARCHAR(255),
    CONSTRAINT fk_contact_company_id
    FOREIGN KEY (company_id) REFERENCES company(id),
    CONSTRAINT fk_contact_company_location_id
     FOREIGN KEY (company_location_id) REFERENCES company_locations(id)
);

-- -----------------------------------------------------
-- TABLE: status
-- -----------------------------------------------------
CREATE TABLE status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    color VARCHAR(7) NOT NULL DEFAULT '#667579',
    display_order INT NOT NULL DEFAULT 0
);

-- -----------------------------------------------------
-- TABLE: project
-- -----------------------------------------------------
CREATE TABLE project (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    company_location_id INT,
    primary_contact_id INT NOT NULL,
    status_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description LONGTEXT,
    planned_start_date DATE,
    planned_end_date DATE,

    CONSTRAINT fk_project_company_id
        FOREIGN KEY (company_id) REFERENCES company(id),

    CONSTRAINT fk_project_company_location_id
        FOREIGN KEY (company_location_id) REFERENCES company_locations(id),

    CONSTRAINT fk_project_primary_contact_id
        FOREIGN KEY (primary_contact_id) REFERENCES contact(id),

    CONSTRAINT fk_projects_status_id
        FOREIGN KEY (status_id) REFERENCES status(id)
);

-- -----------------------------------------------------
-- TABLE: task
-- -----------------------------------------------------
CREATE TABLE task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    status_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    planned_start_date DATE,
    planned_end_date DATE,
    CONSTRAINT fk_task_project_id
        FOREIGN KEY (project_id) REFERENCES project(id),
    CONSTRAINT fk_task_status_id
        FOREIGN KEY (status_id) REFERENCES status(id)
);

-- -----------------------------------------------------
-- TABLE: service
-- -----------------------------------------------------
CREATE TABLE service (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT
);

-- -----------------------------------------------------
-- TABLE: project_service
-- -----------------------------------------------------
CREATE TABLE project_service (
    project_id INT NOT NULL,
    service_id INT NOT NULL,
    PRIMARY KEY (project_id, service_id),
    CONSTRAINT fk_project_service_project_id
        FOREIGN KEY (project_id) REFERENCES project(id),
    CONSTRAINT fk_project_service_service_id
        FOREIGN KEY (service_id) REFERENCES service(id)
);