/**
 * Author:  LUCA.VISINTAINER
 * Created: 18-feb-2023
 

PALETTE
Lynch #607795
Tropical Blue #CCE1F7
Pigeon Post #A5BEDA
Mirage #121D2A
*/

DROP DATABASE IF EXISTS social_network;

CREATE DATABASE IF NOT EXISTS social_network DEFAULT CHARACTER SET = utf8;

USE social_network;

CREATE TABLE profilo (
    idProfilo                   INT                 NOT NULL    AUTO_INCREMENT, 
    username                    VARCHAR(20)         NOT NULL    UNIQUE,   
    password                    VARCHAR(255)         NOT NULL ,
    email                       VARCHAR(255)         NOT NULL ,
    dataIscrizione              DATETIME            NOT NULL,
    ultimoAccesso               DATETIME,
    biografia                   VARCHAR(255), 
    visibilitaAccount           ENUM('T', 'A', 'AA') DEFAULT 'T', /* Tutti - Amici - Amici di amici */               
    indirizzo                   VARCHAR(100),         
    numeroTelefono              VARCHAR(20),
    professione                 VARCHAR(255),
    PRIMARY KEY(idProfilo)
) ENGINE = InnoDB;

CREATE TABLE post (
    idPost                       INT                 NOT NULL    AUTO_INCREMENT,
    data                         DATETIME            NOT NULL,   
    descrizione                  VARCHAR(255),
    fkProfilo                    INT                 NOT NULL,
    tipoPost                     ENUM('N', 'P') NOT NULL DEFAULT 'N',    	/* Normale - Pubblicitario */ 
    prezzo                       DECIMAL DEFAULT 0,
    FOREIGN KEY(fkProfilo) REFERENCES profilo(idProfilo) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(idPost)
) ENGINE = InnoDB;

CREATE TABLE commento (
    idCommento                   INT                 NOT NULL    AUTO_INCREMENT,
    data                         DATETIME            NOT NULL,
    testo                        VARCHAR(255)        NOT NULL,
    fkProfilo                    INT                 NOT NULL,    
    fkPost                       INT                 NOT NULL, 
    stato                        ENUM('PUBBLICATO', 'ELIMINATO') NOT NULL,
    FOREIGN KEY(fkProfilo) REFERENCES profilo(idProfilo)  ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(fkPost) REFERENCES post(idPost)  ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(idCommento)
) ENGINE = InnoDB;                                                        

/**
Nella tabella commento sono presenti i commenti pubblicati(PUBBLICATO) e i commenti eliminati con il post ancora pubblico(ELIMINATO)
Se il post viene eliminato, vengono eliminati anche tutti i commenti(sia quelli pubblicati che quelli eliminati in precedenza)
*/

CREATE TABLE miPiace (
    idLike                        INT                 NOT NULL    AUTO_INCREMENT,
    data                          DATETIME           NOT NULL,
    fkProfilo                     INT                 NOT NULL,
    fkPost                        INT                 NOT NULL,
    FOREIGN KEY(fkProfilo) REFERENCES profilo(idProfilo)  ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(fkPost) REFERENCES post(idpost)  ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(idLike,fkProfilo,fkPost)
) ENGINE = InnoDB;  

CREATE TABLE amicizia (
    idAmicizia                    INT                 NOT NULL    AUTO_INCREMENT,
    fkProfilo1                    INT                 NOT NULL,
    fkProfilo2                    INT                 NOT NULL,
    stato                         ENUM('AMICI', 'IN ATTESA') NOT NULL,
    data                          DATETIME           NOT NULL,
    FOREIGN KEY(fkProfilo1) REFERENCES profilo(idProfilo)  ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(fkProfilo2) REFERENCES profilo(idProfilo)  ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(idAmicizia)
) ENGINE = InnoDB;

CREATE TABLE notifiche (
    idNotifica                    INT                 NOT NULL    AUTO_INCREMENT,
    fkProfilo                     INT                 NOT NULL,     /* CHI HA RICEVUTO LA NOTIFICA*/
    tipo                          ENUM('LIKE','COMMENT') NOT NULL,   
    /* LIKE: qualcuno ha messo like al post di fkProfilo COMMENT: qualcuno ha aggiunto un commento a un post di fkProfilo */
    idAzione                      INT                 NOT NULL,               /* id commento o like --> si puo andare a vedere chi lo ha messo*/
    view                          BOOLEAN           DEFAULT false,      /* view=FALSE --> la notifica non è stata vista, TRUE --> è stata vista e cancellata da pagina notifiche*/
    data                          DATETIME           NOT NULL,
    FOREIGN KEY(fkProfilo) REFERENCES profilo(idProfilo)  ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(idNotifica)
) ENGINE = InnoDB;



