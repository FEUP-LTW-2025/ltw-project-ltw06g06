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
    fullname VARCHAR(255) NOT NULL,
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
    category VARCHAR(255),
    description text,
    FOREIGN KEY (artistId) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (category) REFERENCES Category(name) ON DELETE SET NULL
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
  ('Digital Illustration'),
  ('Logo Design'),
  ('3D Modeling'),
  ('Character Art'),
  ('Concept Art');

-- Insert Users
INSERT INTO Users (id, fullname, username, password, email, profileP) VALUES
  (1, 'Alice Carter', 'alicec', 'pass123', 'alice@example.com', 'default.png'),
  (2, 'John Doe', 'johnd', 'pass123', 'john@example.com', 'default.png'),
  (3, 'Maria Gomez', 'maria_g', 'pass123', 'maria@example.com', 'default.png'),
  (4, 'Leo Nakamura', 'leo3d', 'pass123', 'leo@example.com', 'default.png'),
  (5, 'Chloe Bennett', 'chloeb', 'pass123', 'chloe@example.com', 'default.png'),
  (6, 'Ethan Ford', 'ethanf', 'pass123', 'ethan@example.com', 'default.png'),
  (7, 'Zara Khan', 'zarak', 'pass123', 'zara@example.com', 'default.png'),
  (8, 'Noah Miller', 'noahm', 'pass123', 'noah@example.com', 'default.png');

-- Insert Clients
INSERT INTO Client (clientId, isAdmin) VALUES
  (2, 0),
  (6, 0),
  (7, 0),
  (8, 0);

-- Insert Artists
INSERT INTO Artist (artistId, rating, category, description) VALUES
  (1, 4.5, 'Character Art', 'Freelance character artist with 5+ years experience.'),
  (3, 4.2, 'Logo Design', 'Specialized in minimalistic and modern logo designs.'),
  (4, 4.8, '3D Modeling', '3D modeler for games and animation.'),
  (5, 4.0, 'Digital Illustration', 'Conceptual illustrations and book covers.');

-- Insert Services
INSERT INTO Service (serviceId, cost, image, artistId, serviceName, rating, category, requests, description, avgTime) VALUES
  (1, 50.0, 'example.png', 1, 'Custom Character Portrait', 4.5, 'Character Art', 10, 'Unique portraits for your RPG or book characters.', 3.0),
  (2, 80.0, 'example.png', 3, 'Minimal Logo Design', 4.2, 'Logo Design', 7, 'Clean, timeless logo design for your brand.', 2.0),
  (3, 120.0, 'example.png', 4, 'Stylized 3D Avatar', 4.8, '3D Modeling', 5, 'Custom stylized 3D characters for games.', 4.5),
  (4, 65.0, 'example.png', 5, 'Book Cover Illustration', 4.0, 'Digital Illustration', 8, 'Full-color digital book covers for all genres.', 3.5),
  (5, 90.0, 'example.png', 1, 'Fantasy Character Sheet', 4.7, 'Character Art', 6, 'Detailed full-body character sheets with poses and equipment.', 4.0),
  (6, 70.0, 'example.png', 3, 'Animated Logo Reveal', 4.6, 'Logo Design', 5, 'Short animated intro for your brand or YouTube channel.', 2.5),
  (7, 150.0, 'example.png', 4, '3D Environment Prop', 4.9, '3D Modeling', 4, 'Game-ready props or small scenes for stylized environments.', 5.0),
  (8, 55.0, 'example.png', 5, 'Social Media Banner Art', 4.3, 'Digital Illustration', 7, 'Custom banners for Twitch, YouTube, or Twitter.', 3.0);

-- Insert Reviews
INSERT INTO Review (comment, rating, clientId, serviceId, date) VALUES
  ('Amazing detail and expression!', 5.0, 2, 1, '2024-12-12'),
  ('Captured my DnD character perfectly!', 4.0, 6, 1, '2024-12-15'),

  ('Nice and professional.', 4.0, 7, 2, '2025-01-10'),
  ('Good value for money.', 4.5, 8, 2, '2025-01-12'),

  ('Outstanding modeling skills.', 5.0, 6, 3, '2025-02-02'),
  ('Will hire again!', 4.5, 7, 3, '2025-02-06'),

  ('Nice but took a bit long.', 3.5, 2, 4, '2025-03-01'),
  ('Loved the final result!', 4.5, 8, 4, '2025-03-04');


INSERT INTO Review (comment, rating, clientId, serviceId, date) VALUES
  ('Beautiful and super detailed work.', 5.0, 6, 5, '2025-03-12'),
  ('Exactly what I needed for my campaign!', 4.5, 8, 5, '2025-03-15');

-- Reviews for Service 6
INSERT INTO Review (comment, rating, clientId, serviceId, date) VALUES
  ('Great animation and branding impact.', 5.0, 2, 6, '2025-03-20'),
  ('Smooth and eye-catching.', 4.2, 7, 6, '2025-03-22');

-- Reviews for Service 7
INSERT INTO Review (comment, rating, clientId, serviceId, date) VALUES
  ('The prop looked stunning in Unreal Engine!', 5.0, 6, 7, '2025-04-01'),
  ('Very professional and responsive.', 4.8, 8, 7, '2025-04-03');

-- Reviews for Service 8
INSERT INTO Review (comment, rating, clientId, serviceId, date) VALUES
  ('Cool banner! Very aesthetic.', 4.5, 2, 8, '2025-04-07'),
  ('Colors and layout were perfect.', 4.0, 7, 8, '2025-04-09');


-- Insert Requests
INSERT INTO Request (description, clientId, serviceId, status, date) VALUES
  ('Need a portrait for my elf sorcerer.', 2, 1, 'COMPLETE', '2024-12-10'),
  ('Company rebranding project.', 7, 2, 'COMPLETE', '2025-01-09'),
  ('Game-ready 3D model of sci-fi hero.', 6, 3, 'PENDING', '2025-02-01'),
  ('Romance novel cover with forest background.', 8, 4, 'COMPLETE', '2025-03-02'),
  ('Looking for a custom elf mage character sheet.', 6, 5, 'PENDING', '2025-03-10'),
  ('Animated logo for my YouTube channel.', 2, 6, 'COMPLETE', '2025-03-18'),
  ('Need forest crate models for a 3D puzzle game.', 8, 7, 'PENDING', '2025-04-02'),
  ('Twitter header with galaxy theme.', 7, 8, 'COMPLETE', '2025-04-05');