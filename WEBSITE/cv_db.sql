create database if not exists cv_builder;
use cv_builder;
create table utilisateur(id integer primary key ,email varchar(50), password varchar(100));
create table cv(id INTEGER primary key,id_user integer ,
foreign key(id_user) references utilisateurs(id));
create table info_personnels(id INTEGER primary key,nom varchar(30),prenom varchar (30),photo blob , cv_id integer,
foreign key (cv_id) references cv(id));
create table about(id INTEGER primary key,about_text text ,cv_id integer,
foreign key (cv_id) references cv(id));
create table contact(id INTEGER primary key,whatsapp text,email text,linkedin text,cv_id integer,
foreign key (cv_id) references cv(id));
create table cert_provid(id INTEGER primary key,name varchar(20),logo blob);
create table langues(id INTEGER primary key,name varchar(20));
create table certification(id INTEGER primary key,name text ,date_recu date,id_provid integer,cv_id integer,
foreign key (cv_id) references cv(id),
foreign key (id_provid) references cert_provid(id));
create table lang_cv(cv_id integer,lang_id integer,primary key (cv_id, lang_id),
foreign key (cv_id) references cv(id),
foreign key (lang_id) references langues(id));
create table competance(id INTEGER primary key,competance text ,cv_id integer,
foreign key (cv_id) references cv(id));
create table sous_competance(id integer primary key ,sous_comp text,comp_id integer, 
foreign key (comp_id) references competance(id));
create table formation(id integer primary key,description text,etablissement varchar(50),date_debut date,date_fin date,cv_id integer,
foreign key (cv_id) references cv(id));

INSERT INTO langues (name) VALUES 
('Arabe'),
('Français'),
('Anglais'),
('Allemand'),
('Espagnol'),
('Chinois');

INSERT INTO cert_provid (name) VALUES 
('IBM'), 
('CISCO'),
('HUAWEI'), 
('COURSERA'),
('UDEMY');