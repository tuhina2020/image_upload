create database images_sql;
use images_sql;
create table image_new(
  ID integer NOT NULL auto_increment,
  name varchar(50),
  PRICE integer,
  IMAGE mediumblob NOT NULL,
  IMAGE_256 mediumblob,
  IMAGE_512 mediumblob,
  primary key(id)
);
