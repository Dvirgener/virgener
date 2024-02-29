

CREATE TABLE IF NOT EXISTS users(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    actual_rank varchar(255) NOT NULL,
    number_rank bigint(20) NOT NULL,
    serial_number bigint(20) unsigned NOT NULL,
    classification varchar(255) NOT NULL,
    position varchar(255) NOT NULL,
    section varchar(255) NOT NULL,
    authority varchar(255) NOT NULL,
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
    sub_ben varchar(255) NOT NULL,
    mode_imp varchar(255) NOT NULL,
    mode_proc varchar(255) NOT NULL,
    first_amount decimal(20,2) NULL,
    first_actual decimal(20,2) NULL,
    first_saa bigint(20) NULL,
    first_dv bigint(20) NULL,
    first_obr bigint(20) NULL,
    first_aar bigint(20) NULL,
    second_amount decimal(20,2) NULL,
    second_actual decimal(20,2) NULL,
    second_saa bigint(20) NULL,
    second_dv bigint(20) NULL,
    second_obr bigint(20) NULL,
    second_aar bigint(20) NULL,
    third_amount decimal(20,2) NULL,
    third_actual decimal(20,2) NULL,
    third_saa bigint(20) NULL,
    third_dv bigint(20) NULL,
    third_obr bigint(20) NULL,
    third_aar bigint(20) NOT NULL,
    fourth_amount decimal(20,2) NULL,
    fourth_actual decimal(20,2) NULL,
    fourth_saa bigint(20) NULL,
    fourth_dv bigint(20) NULL,
    fourth_obr bigint(20) NULL,
    fourth_aar bigint(20) NULL,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    added_by bigint(20) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS saa_table (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    saa_desc varchar(500) NOT NULL,
    saa_quarter varchar(255) NOT NULL,
    saa_number varchar(255) NOT NULL,
    saa_acct_code varchar(255) NOT NULL,
    saa_amount decimal(20,2) NOT NULL,
    saa_date datetime NOT NULL,
    saa_remarks varchar(255) NOT NULL,
    saa_file varchar(255),
    saa_origFile varchar(255),
    saa_type varchar(255),
    activity_ids varchar(500),
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    added_by bigint(20) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS work (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    subject varchar(255) NOT NULL,
    instructions varchar(500) NOT NULL,
    assigned_to varchar (255) NOT NULL,
    type varchar (255) NOT NULL,
    added_by bigint(20) unsigned NOT NULL,
    added_from varchar(255) NOT NULL,
    status varchar(255) NOT NULL,
    created_at date NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    updated_at date NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    date_target date NOT NULL,
    date_complied date NOT NULL,
    complied_by bigint(20) NOT NULL,
    timeliness varchar(255) NOT NULL,
    files varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS sub_work (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    main_id bigint(20) unsigned NOT NULL,
    sub_subject varchar(500) NOT NULL,
    assigned_to varchar (255) NOT NULL,
    status varchar(255) NOT NULL,
    created_at date NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id),
    FOREIGN KEY (main_id) REFERENCES work (id)
);



CREATE TABLE IF NOT EXISTS updates (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    main_id bigint(20) unsigned NOT NULL,
    sub_id bigint(20) unsigned NOT NULL,
    remarks varchar (510) NOT NULL,
    files varchar(510) NOT NULL,
    final varchar(255) NOT NULL DEFAULT 'NO',
    updated_by varchar(255) NOT NULL,
    created_at date NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id),
    FOREIGN KEY (main_id) REFERENCES work (id)
);

CREATE TABLE IF NOT EXISTS uploads(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT, -- id of the file in DB
    upload_from varchar (255) NOT NULL,
    file_original_name varchar (510) NOT NULL,
    file_save_name varchar (510) NOT NULL,
    file_type varchar (255) NOT NULL,
    file_extension varchar (255) NOT NULL,
    created_at date NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
)


