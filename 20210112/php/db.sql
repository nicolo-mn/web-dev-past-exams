CREATE DATABASE esami;
USE esami;

CREATE TABLE contagi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE,
    numerocontagi INT
);

INSERT INTO contagi (data, numerocontagi) VALUES ('2022-01-01', 100);
INSERT INTO contagi (data, numerocontagi) VALUES ('2022-01-02', 150);
INSERT INTO contagi (data, numerocontagi) VALUES ('2022-01-03', 200);