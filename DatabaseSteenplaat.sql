/* Code by Yusuf en Gino */
DROP DATABASE IF EXISTS steenplaat;
CREATE DATABASE steenplaat;
USE steenplaat;

CREATE TABLE afspraken(
	af_Voornaam VARCHAR(25) NOT NULL,
	af_Achternaam VARCHAR(50) NOT NULL,
	af_Plaats VARCHAR(100) NOT NULL,
	af_Straatnaam VARCHAR(75) NOT NULL,
	af_Huisnummer INT(4) NOT NULL,
	af_Datum VARCHAR(100) NOT NULL,
	af_Tijdstip VARCHAR(15) NOT NULL,
	af_Operatie VARCHAR(50)
);
/* Code by Ibrahim */
INSERT INTO afspraken VALUES('Yusuf','Ozmen','Rotterdam','Bergwegstraat',175,'2019-11-21','12:10:11','Controle');
INSERT INTO afspraken VALUES('Ibrahim','Ould Amar','Utrecht','lanserstraat',134,'2019-11-22','13:15:51','Kies uittrekken');
INSERT INTO afspraken VALUES('Gino','Traousis','Rotterdam','grootbootstraat',174,'2019-11-23','15:23:43','Tandvlees snijden');
INSERT INTO afspraken VALUES('Laurens','Frensen','Rijswijk','redenstraat',158,'2019-11-24','14:21:22','Controle');

