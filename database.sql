

CREATE TABLE IF NOT EXISTS users(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    actual_rank varchar(255) NOT NULL,
    number_rank bigint(20) NOT NULL,
    serial_number bigint(20) unsigned NOT NULL,
    position varchar(255) NOT NULL,
    classification varchar(255) NOT NULL,
    status varchar(255) NOT NULL,
    remarks varchar(255) NOT NULL,
    picture varchar(255) NOT NULL,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY(id),
    UNIQUE KEY(email)
);

CREATE TABLE IF NOT EXISTS karaoke(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    artist varchar(255) NOT NULL,
    title varchar(255) NOT NULL,
    youtube varchar(255) NOT NULL,
    mode varchar(255) NOT NULL,
    plays bigint(20) NOT NULL DEFAULT '0',
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    added_by varchar(255) NOT NULL,
    PRIMARY KEY(id)
);

