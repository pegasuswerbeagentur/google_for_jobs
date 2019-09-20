#
# Table structure for table 'tx_googleforjobs_domain_model_job'
#
CREATE TABLE tx_googleforjobs_domain_model_job (

	title varchar(255) DEFAULT '' NOT NULL,
	description text,
	employment_type varchar(255) DEFAULT '' NOT NULL,
	date_posted date DEFAULT NULL,
	valid_through date DEFAULT NULL,
	hiring_organization_name varchar(255) DEFAULT '' NOT NULL,
	hiring_organization_website varchar(255) DEFAULT '' NOT NULL,
	hiring_organization_logo_url varchar(255) DEFAULT '' NOT NULL,
	job_location_street_address varchar(255) DEFAULT '' NOT NULL,
	job_location_city varchar(255) DEFAULT '' NOT NULL,
	job_location_postal_code varchar(255) DEFAULT '' NOT NULL,
	job_location_region varchar(255) DEFAULT '' NOT NULL,
	job_location_country varchar(255) DEFAULT '' NOT NULL,
	base_salary_enable tinyint(1) DEFAULT '0' NOT NULL,
	base_salary_currency varchar(255) DEFAULT '' NOT NULL,
	base_salary_unit_text varchar(255) DEFAULT '' NOT NULL,
	base_salary_value double(11,2) DEFAULT '0.00' NOT NULL,
	job_location_type tinyint(1) DEFAULT '0' NOT NULL,
	applicant_location_requirements varchar(255) DEFAULT '' NOT NULL,

);
