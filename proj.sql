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
    username VARCHAR(255) NOT NULL UNIQUE,
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
    description text,
    FOREIGN KEY (artistId) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Service (
    serviceId INTEGER PRIMARY KEY,
    cost REAL NOT NULL CHECK (cost > 0),
    image VARCHAR(255),
    artistId INTEGER NOT NULL,
    serviceName VARCHAR(255) NOT NULL,
    rating REAL NOT NULL  CHECK (rating <= 5 AND rating >= 0),
    category VARCHAR(255),
    requests INTEGER CHECK ( requests > 0),
    description text,
    avgTime REAL NOT NULL CHECK (avgTime > 0),
    FOREIGN KEY (artistId) REFERENCES Artist(artistId) ON DELETE CASCADE,
    FOREIGN KEY (category) REFERENCES Category(name) ON DELETE SET NULL
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



INSERT INTO Category (name) VALUES
  ('Digital Art'),
  ('Illustration'),
  ('3D Modeling'),
  ('Pixel Art'),
  ('Concept Art'),
  ('Comic Art');

-- Insert Users
INSERT INTO Users (id, username, password, email, profileP) VALUES
  (1, 'anna_client', 'pass1', 'anna@example.com', NULL),
  (2, 'mike_client', 'pass2', 'mike@example.com', NULL),
  (3, 'luna_artist', 'pass3', 'luna@example.com', NULL),
  (4, 'neo_artist', 'pass4', 'neo@example.com', NULL),
  (5, 'julia_client', 'pass5', 'julia@example.com', NULL),
  (6, 'max_artist', 'pass6', 'max@example.com', NULL),
  (7, 'sara_client', 'pass7', 'sara@example.com', NULL),
  (8, 'ivy_artist', 'pass8', 'ivy@example.com', NULL);

-- Insert Clients
INSERT INTO Client (clientId, isAdmin) VALUES
  (1, 0),
  (2, 1),
  (5, 0),
  (7, 0);

-- Insert Artists
INSERT INTO Artist (artistId, rating, description) VALUES
  (3, 4.7, 'Fantasy digital painter.'),
  (4, 4.2, '3D modeling expert for game assets.'),
  (6, 4.9, 'Comic and concept artist with bold style.'),
  (8, 3.8, 'Pixel art designer for indie games.');

-- Insert Services
INSERT INTO Service (serviceId, cost, image, artistId, serviceName, rating, category, requests, description, avgTime) VALUES
  (1, 50.0, NULL, 3, 'Fantasy Portrait', 4.7, 'Digital Art', 12, 'Detailed fantasy portraits.', 2.5),
  (2, 75.0, NULL, 4, 'Game Sword 3D Model', 4.2, '3D Modeling', 7, 'Sword model optimized for game engines.', 3.0),
  (3, 40.0, NULL, 6, 'Comic Strip - 4 Panels', 4.9, 'Comic Art', 15, 'Custom 4-panel comic strips.', 1.5),
  (4, 30.0, NULL, 8, 'Retro Pixel Character', 3.8, 'Pixel Art', 5, '8-bit style character sprites.', 1.0),
  (5, 60.0, NULL, 6, 'Concept Character Design', 4.9, 'Concept Art', 10, 'Detailed character concepts for games.', 2.8),
  (6, 35.0, NULL, 8, 'Pixel Art Tileset', 3.8, 'Pixel Art', 4, 'Tile-based pixel environment assets.', 2.0);

-- Insert Reviews
INSERT INTO Review (comment, rating, clientId, serviceId, date) VALUES
  ('Amazing portrait!', 4.7, 1, 1, '2025-04-01'),
  ('Very professional 3D model!', 4.2, 2, 2, '2025-04-02'),
  ('Perfect comic art, hilarious and sharp.', 4.9, 5, 3, '2025-04-04'),
  ('Great for my retro game!', 3.8, 7, 4, '2025-04-05'),
  ('Concept art helped me pitch my game!', 4.9, 1, 5, '2025-04-06'),
  ('Detailed and colorful tiles!', 3.8, 2, 6, '2025-04-07');

-- Insert Requests
INSERT INTO Request (description, clientId, serviceId, status, date) VALUES
  ('Need a fantasy elf character.', 1, 1, 'COMPLETE', '2025-03-30'),
  ('Sword model for mobile game.', 2, 2, 'PENDING', '2025-04-03'),
  ('Comic strip about office humor.', 5, 3, 'COMPLETE', '2025-04-04'),
  ('Pixel art for a dungeon game.', 7, 4, 'PENDING', '2025-04-05'),
  ('Character for my RPG.', 1, 5, 'COMPLETE', '2025-04-06'),
  ('Tileset for overworld map.', 2, 6, 'PENDING', '2025-04-07');