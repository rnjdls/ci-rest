Database name: ci_rest_poc

CREATE TABLE users (
id int NOT NULL auto_increment, 
first_name varchar(64), 
last_name varchar(64), 
username varchar(30), 
password varchar(64), 
PRIMARY KEY (id));