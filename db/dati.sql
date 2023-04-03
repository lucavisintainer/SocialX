/* Profili */
INSERT INTO profilo (username, password, email, dataIscrizione, ultimoAccesso, biografia, visibilitaAccount, indirizzo, numeroTelefono, professione) VALUES
('mario95', 'passwordmario', 'mario95@mail.com', '2022-01-01 10:00:00', '2022-01-01 10:00:00', 'Ciao a tutti, sono Mario!', 'T', 'Via Roma 1', '3331234567', 'Programmatore'),
('anna87', 'passwordanna', 'anna87@mail.com', '2022-01-02 11:00:00', '2022-01-02 11:00:00', 'Sono Anna e mi piace viaggiare!', 'T', 'Via Verdi 2', '3337654321', 'Insegnante'),
('luca80', 'passwordluca', 'luca80@mail.com', '2022-01-03 12:00:00', '2022-01-03 12:00:00', 'Ciao a tutti, sono Luca!', 'T', 'Via Galileo Galilei 3', '3339876543', 'Medico'),
('giulia91', 'passwordgiulia', 'giulia91@mail.com', '2022-01-04 13:00:00', '2022-01-04 13:00:00', 'Sono Giulia e adoro cucinare!', 'T', 'Via Dante Alighieri 4', '3332345678', 'Cuoco'),
('mario01', 'passwordmario', 'mario01@mail.com', '2022-03-17 10:30:00', '2022-03-17 12:30:00', 'Sono un appassionato di tecnologia', 'A', 'Via Roma 1', '1234567890', 'Ingegnere informatico'),
('laura92', 'passwordlaura', 'laura92@mail.com', '2022-03-17 11:30:00', '2022-03-17 13:30:00', 'Appassionata di viaggi e cucina', 'T', 'Via Dante Alighieri 3', '0987654321', 'Cuoca'),
('giovanni88', 'passwordgiovanni', 'giovanni88@mail.com', '2022-03-17 12:30:00', '2022-03-17 14:30:00', 'Innamorato dello sport e della natura', 'T', 'Via Garibaldi 5', '3471234567', 'Insegnante di educazione fisica'),
('francesca85', 'passwordfrancesca', 'francesca85@mail.com', '2022-03-17 13:30:00', '2022-03-17 15:30:00', 'Amante della musica e del cinema', 'A', 'Via Mazzini 7', '3456789012', 'Musicista'),
('marco79', 'passwordmarco', 'marco79@mail.com', '2022-03-17 14:30:00', '2022-03-17 16:30:00', 'Appassionato di sport e tecnologia', 'A', 'Via Verdi 9', '5678901234', 'Ingegnere meccanico'),
('andrea93', 'passwordandrea', 'andrea93@mail.com', '2022-03-18 15:30:00', '2022-03-18 16:30:00', 'Sono appassionato di fotografia e di tecnologia', 'T', 'Via dei Mille 10', '3456789123', 'Fotografo'),
('silvia88', 'passwordsilvia', 'silvia88@mail.com', '2022-03-19 14:30:00', '2022-03-19 15:30:00', 'Amante della lettura e della natura', 'T', 'Via Garibaldi 15', '3491234567', 'Libraia'),
('fabio85', 'passwordfabio', 'fabio85@mail.com', '2022-03-20 13:30:00', '2022-03-20 14:30:00', 'Appassionato di cinema e musica rock', 'A', 'Via del Corso 20', '3334567890', 'Musicista'),
('simone90', 'passwordsimone', 'simone90@mail.com', '2022-03-21 12:30:00', '2022-03-21 13:30:00', 'Innamorato del mare e degli animali', 'T', 'Via della Repubblica 25', '3478901234', 'Biologo marino'),
('valentina91', 'passwordvalentina', 'valentina91@mail.com', '2022-03-22 11:30:00', '2022-03-22 12:30:00', 'Sono appassionata di cucina e di viaggi', 'T', 'Via Roma 30', '3456789012', 'Cuoca'),
('francesco87', 'passwordfrancesco', 'francesco87@mail.com', '2022-03-23 10:30:00', '2022-03-23 11:30:00', 'Appassionato di arte e cultura', 'A', 'Via dei Condotti 35', '3490123456', 'Storico');

/* Post */
INSERT INTO post (idPost,data, descrizione, fkProfilo, tipoPost, prezzo) VALUES
(1,'2022-01-05 10:00:00', 'Oggi ho visitato un bellissimo museo!', 1, 'N', 0),
(2,'2022-01-06 11:00:00', 'Sono appena tornata da una vacanza favolosa!', 2, 'N', 0),
(3,'2022-01-07 12:00:00', 'Buongiorno a tutti, oggi è una splendida giornata di sole!', 3, 'N', 0),
(4,'2022-01-08 13:00:00', 'Oggi ho salvato una vita al pronto soccorso!', 4, 'N', 0),
(5,'2022-01-09 14:00:00', 'Prova il nostro nuovo prodotto, è fantastico!', 1, 'P', 50),
(6,'2022-01-10 15:00:00', 'Vieni a provare il nostro ristorante, ti aspettiamo!', 2, 'P', 30),
(7,'2022-01-11 16:00:00', 'Il nostro nuovo libro è finalmente disponibile!', 3, 'P', 20),
(8,'2022-01-12 17:00:00', 'Vieni a provare la nostra nuova ricetta, è deliziosa!', 4, 'P', 40),
(9,'2022-03-17 15:00:00', 'Oggi ho corso la mia prima maratona!', 1, 'N', 0),
(10,'2022-03-16 14:00:00', 'Ho fatto un bellissimo viaggio in Giappone, consiglio a tutti di andarci almeno una volta nella vita!', 2, 'N', 0),
(11,'2022-03-15 13:00:00', 'Oggi ho cucinato una lasagna perfetta!', 2, 'N', 0),
(12,'2022-03-14 12:00:00', 'Questo è il mio primo post su questa piattaforma!', 3, 'N', 0),
(13,'2022-03-13 11:00:00', 'Ieri ho visto il nuovo film di Tarantino, è spettacolare!', 4, 'N', 0),
(14,'2022-03-12 10:00:00', 'Oggi ho suonato il mio nuovo violino, suona alla perfezione!', 4, 'N', 0),
(15,'2022-03-11 09:00:00', 'Stamattina ho fatto una bella passeggiata in montagna', 5, 'N', 0),
(16,'2022-01-01 10:30:00', 'Nuovo post di Mario!', 1, 'N', NULL),
(17,'2022-01-02 11:30:00', 'Viaggio fantastico ad Amsterdam!', 2, 'N', NULL),
(18,'2022-01-03 12:30:00', 'Novità dal mondo della medicina', 3, 'N', NULL),
(19,'2022-01-04 13:30:00', 'Ricetta del mio piatto preferito', 4, 'N', NULL),
(20,'2022-01-05 14:30:00', 'Recensione del nuovo smartphone', 1, 'N', NULL),
(21,'2022-01-06 15:30:00', 'Foto di una magnifica vista', 2, 'N', NULL),
(22,'2022-01-07 16:30:00', 'Nuova scoperta scientifica', 3, 'N', NULL),
(23,'2022-01-08 17:30:00', 'Tutorial per preparare una torta', 4, 'N', NULL),
(24,'2022-03-17 10:45:00', 'Le ultime novità dal mondo della tecnologia', 5, 'N', NULL),
(25,'2022-03-17 11:45:00', 'Ricetta per una cena romantica', 6, 'N', NULL),
(26,'2022-03-17 12:45:00', 'Foto del mio ultimo trekking', 7, 'N', NULL),
(27,'2022-03-17 13:45:00', 'Recensione del nuovo film in uscita', 8, 'N', NULL),
(28,'2022-03-17 14:45:00', 'Foto della mia ultima creazione musicale', 9, 'N', NULL),
(29,'2022-03-17 15:45:00', 'Articolo sulle ultime tendenze nel mondo dello sport', 10, 'N', NULL),
(30,'2022-03-17 16:45:00', 'Nuova invenzione', 11, 'N', NULL),
(31,'2022-03-17 17:45:00', 'Ricetta per una torta a forma di cuore', 6, 'N', NULL);

/* Commenti */
INSERT INTO commento (data, testo, fkProfilo, fkPost, stato) VALUES
('2022-01-13 10:00:00', 'Bellissima esperienza!', 2, 1, 'PUBBLICATO'),
('2022-01-14 11:00:00', 'Wow, che bel posto!', 3, 1, 'PUBBLICATO'),
('2022-01-15 14:30:00', 'Sembra proprio un bel viaggio!', 4, 1, 'PUBBLICATO'),
('2022-01-17 09:45:00', 'Mai visto niente di simile!', 5, 1, 'PUBBLICATO'),
('2022-01-18 16:20:00', 'Stupendo!', 6, 1, 'PUBBLICATO'),
('2022-01-19 08:00:00', 'Che paesaggio mozzafiato!', 7, 1, 'PUBBLICATO'),
('2022-01-20 12:15:00', 'Spero di poter andare anche io un giorno!', 8, 1, 'PUBBLICATO'),
('2022-01-22 09:30:00', 'Fantastico!', 2, 2, 'PUBBLICATO'),
('2022-01-23 13:40:00', 'Ottima scelta, consigliatissimo!', 3, 2, 'PUBBLICATO'),
('2022-01-25 08:50:00', 'Grazie per la segnalazione, lo proverò sicuramente!', 4, 2, 'PUBBLICATO'),
('2022-01-26 11:10:00', 'Wow, non vedo lora di provarlo!', 5, 2, 'PUBBLICATO'),
('2022-01-27 16:00:00', 'Bellissimo, lo raccomando a tutti!', 6, 2, 'PUBBLICATO'),
('2022-01-28 09:20:00', 'Davvero unesperienza unica!', 7, 2, 'PUBBLICATO'),
('2022-01-29 12:30:00', 'Non vedo lora di tornare!', 8, 2, 'PUBBLICATO'),
('2022-02-01 10:15:00', 'Meraviglioso!', 2, 3, 'PUBBLICATO'),
('2022-02-02 15:00:00', 'Che posto incantevole!', 3, 3, 'PUBBLICATO'),
('2022-02-03 08:30:00', 'Fantastico, da provare assolutamente!', 4, 3, 'PUBBLICATO'),
('2022-02-05 14:50:00', 'Grazie per averci fatto scoprire questo posto!', 6, 3, 'PUBBLICATO');


/* Mi piace */
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2022-02-01 10:30:00', 1, 1);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2022-02-02 14:00:00', 2, 1);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2022-02-03 09:15:00', 3, 1);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2022-10-01 14:30:00', 1, 3);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2022-09-15 10:45:00', 2, 5);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2022-11-23 19:15:00', 3, 7);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2022-12-17 08:45:00', 1, 2);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2022-11-05 17:30:00', 3, 4);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2023-01-10 22:00:00', 2, 6);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2023-03-12 13:15:00', 1, 8);
INSERT INTO miPiace (data, fkProfilo, fkPost) VALUES ('2023-02-02 09:00:00', 4, 10);


/* Amicizia */
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (1, 2, 'AMICI', '2022-01-15 18:00:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (2, 3, 'IN ATTESA', '2022-02-10 09:00:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (3, 1, 'AMICI', '2022-03-01 15:30:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (1, 2, 'AMICI', '2022-08-10 11:20:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (2, 3, 'IN ATTESA', '2022-07-22 16:55:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (1, 3, 'AMICI', '2022-09-05 20:10:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (2, 4, 'AMICI', '2022-12-03 19:30:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (3, 5, 'IN ATTESA', '2023-01-15 12:45:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (1, 5, 'IN ATTESA', '2022-10-25 08:00:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (4, 5, 'AMICI', '2022-11-30 16:20:00');
INSERT INTO amicizia (fkProfilo1, fkProfilo2, stato, data) VALUES (2, 3, 'AMICI', '2022-09-22 21:15:00');
