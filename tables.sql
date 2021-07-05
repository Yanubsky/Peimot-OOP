CREATE TABLE IF NOT EXISTS articles (
    id smallint unsigned NOT NULL auto_increment,
    publicationDate date NOT NULL,
    topic varchar (10) NOT NULL,
    articleTitle VARCHAR(255) NOT NULL,
    preface text NOT NULL,
    content text NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS users (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    email varchar(60) NOT NULL UNIQUE,
    pass varchar(60)NOT NULL,
    isAdmin boolean NOT NULL,
    registerDate date NOT NULL,
    userLocation decimal,
    PRIMARY KEY (id)
)