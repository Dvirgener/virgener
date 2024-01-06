

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

CREATE TABLE IF NOT EXISTS table_of_activities(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    year year NOT NULL,
    reviewing_staff varchar(255) NOT NULL,
    acct_code varchar(255) NOT NULL,
    fund_source varchar(255) NOT NULL,
    activity varchar(510) NOT NULL,
    mode_imp varchar(255) NOT NULL,
    mode_proc varchar(255) NOT NULL,
    first_amount decimal(20,2) NOT NULL,
    first_actual decimal(20) NOT NULL,
    first_dv varchar(255) NOT NULL,
    first_obr varchar(255) NOT NULL,
    first_aar varchar(255) NOT NULL,
    second_amount decimal(20,2) NOT NULL,
    second_actual decimal(20) NOT NULL,
    second_dv varchar(255) NOT NULL,
    second_obr varchar(255) NOT NULL,
    second_aar varchar(255) NOT NULL,
    third_amount decimal(20,2) NOT NULL,
    third_actual decimal(20) NOT NULL,
    third_dv varchar(255) NOT NULL,
    third_obr varchar(255) NOT NULL,
    third_aar varchar(255) NOT NULL,
    fourth_amount decimal(20,2) NOT NULL,
    fourth_actual decimal(20) NOT NULL,
    fourth_dv varchar(255) NOT NULL,
    fourth_obr varchar(255) NOT NULL,
    fourth_aar varchar(255) NOT NULL,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    added_by varchar(255) NOT NULL,
    PRIMARY KEY(id)
);

