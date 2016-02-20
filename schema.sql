CREATE TABLE users(
	id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	email VARCHAR(255) UNIQUE,
	token VARCHAR(255),
	type int(2) UNSIGNED,
	username VARCHAR(255) UNIQUE,
	created DATETIME,
	modified DATETIME
);
CREATE TABLE issues(
	id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(255),
	body TEXT,
	user_id int(11) UNSIGNED NOT NULL,
	created DATETIME,
	modified DATETIME,
	FOREIGN KEY(user_id) REFERENCES users(id)
);
CREATE TABLE comments(
	id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	body TEXT,
	created DATETIME,
	modified DATETIME,
	user_id int(11) UNSIGNED NOT NULL,
	issue_id int(11) UNSIGNED NOT NULL,
	FOREIGN KEY(user_id) REFERENCES users(id),
	FOREIGN KEY(issue_id) REFERENCES issues(id)
);

CREATE TABLE photos(
	id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	path VARCHAR(255),
	type VARCHAR(50),
	issue_id int(11) UNSIGNED NOT NULL,
	comment_id int(11) UNSIGNED NOT NULL,
	created DATETIME,
	modified DATETIME,
	FOREIGN KEY(issue_id) REFERENCES issues(id),
	FOREIGN KEY(comment_id) REFERENCES comments(id)
);
CREATE TABLE tags(
	id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	created DATETIME, 
	modified DATETIME
);
CREATE TABLE votes(
	id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	vote tinyint(1),
	user_id int(11) UNSIGNED NOT NULL,
	issue_id int(11) UNSIGNED NOT NULL,
	comment_id int(11) UNSIGNED NOT NULL,
	created DATETIME, 
	modified DATETIME,
	FOREIGN KEY(user_id) REFERENCES users(id),
	FOREIGN KEY(issue_id) REFERENCES issues(id),
	FOREIGN KEY(comment_id) REFERENCES comments(id)
);
CREATE TABLE issues_tags(
	issue_id int(11) UNSIGNED NOT NULL,
	tag_id int(11) UNSIGNED NOT NULL,
	PRIMARY KEY(issue_id, tag_id),
	FOREIGN KEY(issue_id) REFERENCES issues(id),
	FOREIGN KEY(tag_id) REFERENCES tags(id)
);

