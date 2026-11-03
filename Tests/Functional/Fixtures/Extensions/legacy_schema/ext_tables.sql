CREATE TABLE tt_content (
	list_type varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE tx_googleforjobs_domain_model_job (
	job_location_street_address varchar(255) DEFAULT '' NOT NULL,
	job_location_city varchar(255) DEFAULT '' NOT NULL,
	job_location_postal_code varchar(255) DEFAULT '' NOT NULL,
	job_location_region varchar(255) DEFAULT '' NOT NULL,
	job_location_country varchar(255) DEFAULT '' NOT NULL
);
