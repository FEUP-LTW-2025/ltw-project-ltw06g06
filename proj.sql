CREATE TABLE USER {
    id INTEGER PRIMARY KEY,
    username VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    profileP VARCHAR
};

CREATE TABLE Client {
    id INTEGER PRIMARY KEY, 
    isAdmin BOOLEAN,
    FOREIGN KEY (id) REFERENCES USER(id)
};

CREATE TABLE Artist {
    id INTEGER PRIMARY KEY, 
    category VARCHAR NOT NULL,
    RATING REAL NOT NULL,
    description text,
    avgTime REAL NOT NULL,
    FOREIGN KEY (id) REFERENCES USER(id)
};

CREATE TABLE Service {
    id INTEGER PRIMARY KEY,
    Sname VARCHAR NOT NULL,
    category VARCHAR NOT NULL,
    RATING REAL NOT NULL,
    description text,
    avgTime REAL NOT NULL,
    FOREIGN KEY (id) REFERENCES USER(id)
};
