CREATE TABLE fishinfo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    species VARCHAR(100) NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    length DECIMAL(5,2) NOT NULL,
    date_caught VARCHAR(100) NOT NULL
);
