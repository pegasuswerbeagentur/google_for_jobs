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
	job_locations int(11) DEFAULT '0' NOT NULL,
	job_locations_from int(11) DEFAULT '0' NOT NULL,
	base_salary_enable tinyint(1) DEFAULT '0' NOT NULL,
	base_salary_currency varchar(255) DEFAULT '' NOT NULL,
	base_salary_unit_text varchar(255) DEFAULT '' NOT NULL,
	base_salary_value double(11,2) DEFAULT '0.00' NOT NULL,
	job_location_type tinyint(1) DEFAULT '0' NOT NULL,
	applicant_location_requirements varchar(255) DEFAULT '' NOT NULL,
	path_segment varchar(2048),
	fal_media int(11) unsigned DEFAULT '0',
	fal_related_files int(11) unsigned DEFAULT '0',
	author tinytext,
	alternative_title tinytext,
	category tinytext,
	notes text
);

#
# Table structure for table 'tx_googleforjobs_domain_model_joblocation'
#
CREATE TABLE tx_googleforjobs_domain_model_joblocation (

	street_address varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	postal_code varchar(255) DEFAULT '' NOT NULL,
	region varchar(255) DEFAULT '' NOT NULL,
	country varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_googleforjobs_domain_model_job_joblocation_mm'
#

CREATE TABLE tx_googleforjobs_domain_model_job_joblocation_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
