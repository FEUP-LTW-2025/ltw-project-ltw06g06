PRAGMA FOREIGN_KEYS = ON;


DROP TABLE IF EXISTS Request;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS Service;
DROP TABLE IF EXISTS Artist;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Users;

CREATE TABLE Users (
    id INTEGER PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    profileP VARCHAR(255)
);

CREATE TABLE Client (
    clientId INTEGER PRIMARY KEY, 
    isAdmin TINYINT(1) DEFAULT 0,
    FOREIGN KEY (clientId) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Category(
    name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE Artist (
    artistId INTEGER PRIMARY KEY, 
    rating REAL NOT NULL CHECK (rating <= 5 AND rating >= 0),
    category VARCHAR(255),
    description text,
    FOREIGN KEY (category) REFERENCES Category(name) ON DELETE SET NULL,
    FOREIGN KEY (artistId) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Service (
    serviceId INTEGER PRIMARY KEY,
    cost REAL NOT NULL CHECK (cost > 0),
    image VARCHAR(255),
    artistId INTEGER NOT NULL,
    serviceName VARCHAR(255) NOT NULL,
    rating REAL NOT NULL  CHECK (rating <= 5 AND rating >= 0),
    description text,
    avgTime REAL NOT NULL CHECK (avgTime > 0),
    FOREIGN KEY (artistId) REFERENCES Artist(artistId) ON DELETE CASCADE
);


CREATE TABLE Review (
    comment VARCHAR(255) NOT NULL,
    rating REAL NOT NULL,
    clientId INTEGER,
    serviceId INTEGER,
    date DATE NOT NULL,
    PRIMARY KEY (clientId,serviceId),
    FOREIGN KEY (clientId) REFERENCES Client(clientId) ON DELETE CASCADE,
    FOREIGN KEY (serviceId) REFERENCES Service(serviceId) ON DELETE CASCADE
);

CREATE TABLE Request (
    description text NOT NULL,
    clientId INTEGER,
    serviceId INTEGER,
    status VARCHAR(255) CHECK(status = 'COMPLETE' OR status = 'PENDING') NOT NULL,
    date DATE NOT NULL,
    PRIMARY KEY (clientId,serviceId),
    FOREIGN KEY (clientId) REFERENCES Client(clientId) ON DELETE CASCADE,
    FOREIGN KEY (serviceId) REFERENCES Service(serviceId) ON DELETE CASCADE
);



INSERT INTO Users (id, username, password, email, profileP) VALUES
(1, 'john_doe', 'hashed_password1', 'john@example.com', NULL),
(2, 'jane_artist', 'hashed_password2', 'jane@example.com', NULL),
(3, 'mike_photo', 'hashed_password3', 'mike@example.com', NULL),
(4, 'emily_paint', 'hashed_password4', 'emily@example.com', NULL),
(5, 'alex_graphic', 'hashed_password5', 'alex@example.com', NULL);

-- Insert Clients (Clients are Users)
INSERT INTO Client (clientId, isAdmin) VALUES
(1, 0),  -- John is a regular client
(5, 1);  -- Alex is an admin client

-- Insert Categories (Visual Art Types)
INSERT INTO Category (name) VALUES
('Painting'),
('Illustration'),
('Photography'),
('Graphic Design'),
('3D Modeling');

-- Insert Artists (Artists are Users)
INSERT INTO Artist (artistId, rating, category, description) VALUES
(2, 4.8, 'Illustration', 'Freelance illustrator specializing in book covers and digital art.'),
(3, 4.5, 'Photography', 'Professional photographer with experience in portrait and nature photography.'),
(4, 4.9, 'Painting', 'Traditional and digital painter specializing in landscapes and portraits.');

-- Insert Services (Offered by Artists)
INSERT INTO Service (serviceId, cost, image, artistId, serviceName, rating, description, avgTime) VALUES
(1, 150.00, NULL, 2, 'Custom Digital Illustration', 4.8, 'High-quality custom illustrations for books, games, and more.', 5.0),
(2, 80.00, NULL, 3, 'Professional Portrait Photography', 4.5, 'Capture your best moments with professional lighting and editing.', 3.0),
(3, 200.00, NULL, 4, 'Custom Landscape Painting', 4.9, 'Hand-painted landscapes on canvas or digital.', 7.0);

-- Insert Reviews (Clients Reviewing Services) - Matching Ratings
INSERT INTO Review (comment, rating, clientId, serviceId, date) VALUES
('Amazing work! Would recommend.', 4.8, 1, 1, '2024-03-15'),
('Great service, very professional.', 4.5, 1, 2, '2024-03-20'),
('Beautiful painting, exceeded expectations.', 4.9, 5, 3, '2024-04-01');

-- Insert Requests (Clients Requesting Services)
INSERT INTO Request (description, clientId, serviceId, status, date) VALUES
('I need a fantasy-style book cover illustration.', 1, 1, 'COMPLETE', '2024-03-10'),
('A portrait session for my graduation photos.', 1, 2, 'COMPLETE', '2024-03-18'),
('A landscape painting for my living room.', 5, 3, 'COMPLETE', '2024-04-02');