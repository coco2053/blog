
CREATE TABLE role (
                id_role INT AUTO_INCREMENT NOT NULL,
                role_type VARCHAR(50) NOT NULL,
                PRIMARY KEY (id_role)
);


CREATE TABLE rights (
                id_rights INT AUTO_INCREMENT NOT NULL,
                rights VARCHAR(50) NOT NULL,
                id_role INT NOT NULL,
                PRIMARY KEY (id_rights)
);


CREATE TABLE user (
                id_user INT AUTO_INCREMENT NOT NULL,
                mail VARCHAR(255) NOT NULL,
                pass VARCHAR(255) NOT NULL,
                username VARCHAR(50) NOT NULL,
                lastname VARCHAR(100) NOT NULL,
                firstname VARCHAR(100) NOT NULL,
                id_role INT NOT NULL,
                PRIMARY KEY (id_user)
);


CREATE TABLE post (
                id_post INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(255) NOT NULL,
                chapo VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                creation_date DATETIME NOT NULL,
                update_date DATETIME NOT NULL,
                id_user INT NOT NULL,
                PRIMARY KEY (id_post)
);


CREATE TABLE comment (
                id_comment INT AUTO_INCREMENT NOT NULL,
                titre VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                creation_date DATETIME NOT NULL,
                id_user INT NOT NULL,
                id_post INT NOT NULL,
                PRIMARY KEY (id_comment)
);


ALTER TABLE user ADD CONSTRAINT role_utilisateur_fk
FOREIGN KEY (id_role)
REFERENCES role (id_role)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE rights ADD CONSTRAINT role_droits_fk
FOREIGN KEY (id_role)
REFERENCES role (id_role)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE comment ADD CONSTRAINT utilisateur_commentaire_fk
FOREIGN KEY (id_user)
REFERENCES user (id_user)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE post ADD CONSTRAINT utilisateur_post_fk
FOREIGN KEY (id_user)
REFERENCES user (id_user)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE comment ADD CONSTRAINT post_commentaire_fk
FOREIGN KEY (id_post)
REFERENCES post (id_post)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
