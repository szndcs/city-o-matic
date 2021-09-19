CREATE DATABASE zengo_test;
CREATE TABLE counties (
     id INT(2) NOT NULL AUTO_INCREMENT,
     name VARCHAR(30) CHARACTER SET latin2 COLLATE latin2_hungarian_ci NOT NULL,
     PRIMARY KEY (id)
     ) ENGINE = InnoDB
     CHARSET=latin2 COLLATE latin2_hungarian_ci;
CREATE TABLE cities (
     id INT(2) NOT NULL AUTO_INCREMENT,
     name VARCHAR(30) CHARACTER SET latin2 COLLATE latin2_hungarian_ci NOT NULL,
     county_id INT(2) NOT NULL,
     PRIMARY KEY (id),
     FOREIGN KEY (county_id)
          REFERENCES counties (id)
          ON UPDATE RESTRICT ON DELETE CASCADE
     ) ENGINE = InnoDB
     CHARSET=latin2 COLLATE latin2_hungarian_ci;

INSERT INTO counties (id, name) VALUES
     (NULL, 'Bács-Kiskun'),
     (NULL, 'Baranya'),
     (NULL, 'Békés'),
     (NULL, 'Borsod-Abaúj-Zemplén'),
     (NULL, 'Csongrád-Csanád'),
     (NULL, 'Fejér'),
     (NULL, 'Győr-Moson-Sopron'),
     (NULL, 'Hajdú-Bihar'),
     (NULL, 'Heves'),
     (NULL, 'Jász-Nagykun-Szolnok'),
     (NULL, 'Komárom-Esztergom'),
     (NULL, 'Nógrád'),
     (NULL, 'Pest'),
     (NULL, 'Somogy'),
     (NULL, 'Szabolcs-Szatmár-Bereg'),
     (NULL, 'Tolna'),
     (NULL, 'Vas'),
     (NULL, 'Veszprém'),
     (NULL, 'Zala');