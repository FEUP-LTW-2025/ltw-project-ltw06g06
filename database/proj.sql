PRAGMA FOREIGN_KEYS = ON;

DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS CustomService;
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
    requests INTEGER CHECK ( requests >= 0),
    description text,
    avgTime REAL NOT NULL CHECK (avgTime > 0),
    FOREIGN KEY (artistId) REFERENCES Artist(artistId) ON DELETE CASCADE,
    FOREIGN KEY (category) REFERENCES Category(name) ON DELETE SET NULL
);


CREATE TABLE Review (
    comment VARCHAR(255) NOT NULL,
    rating INTEGER NOT NULL CHECK(0 < rating AND rating <=5),
    clientId INTEGER,
    serviceId INTEGER,
    date DATE NOT NULL,
    PRIMARY KEY (clientId,serviceId),
    FOREIGN KEY (clientId) REFERENCES Client(clientId) ON DELETE CASCADE,
    FOREIGN KEY (serviceId) REFERENCES Service(serviceId) ON DELETE CASCADE
);

CREATE TABLE Request (
    requestId INTEGER PRIMARY KEY AUTOINCREMENT,
    description text NOT NULL,
    clientId INTEGER,
    serviceId INTEGER,
    status VARCHAR(255) CHECK(status = 'COMPLETE' OR status = 'PENDING') NOT NULL DEFAULT 'PENDING',
    date DATE NOT NULL,
    FOREIGN KEY (clientId) REFERENCES Client(clientId) ON DELETE CASCADE,
    FOREIGN KEY (serviceId) REFERENCES Service(serviceId) ON DELETE CASCADE
);

 CREATE TABLE CustomService (
    Cname VARCHAR(255) NOT NULL,
    CserviceId INTEGER,
    description text NOT NULL,
    clientId INTEGER,
    artistId INTEGER,
    cost REAL NOT NULL CHECK (cost > 0),
    image VARCHAR(255),
    status VARCHAR(255) CHECK(status = 'COMPLETE' OR status = 'PENDING') NOT NULL DEFAULT 'PENDING',
    date DATE NOT NULL,
    PRIMARY KEY (CserviceId),
    FOREIGN KEY (clientId) REFERENCES Client(clientId) ON DELETE CASCADE,
    FOREIGN KEY (artistId) REFERENCES Artist(artistId) ON DELETE CASCADE
);

CREATE TABLE Message (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    senderId INTEGER NOT NULL,
    serviceId INTEGER NOT NULL,
    receiverId INTEGER NOT NULL,
    requestId INTEGER NOT NULL,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (senderId) REFERENCES Users(id),
    FOREIGN KEY (receiverId) REFERENCES Users(id),
    FOREIGN KEY (requestId) REFERENCES Request(requestId)
);


-- Insert Categories
INSERT INTO Category (name) VALUES
  ('Digital Illustration'),
  ('Logo Design'),
  ('3D Modeling'),
  ('Character Art'),
  ('Concept Art');

INSERT INTO Users (id, fullname, username, password, email, profileP) VALUES
  (1, 'Alice Carter', 'alicec', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'alice@example.com', 'https://picsum.photos/seed/u1/200'),
  (2, 'John Doe', 'johnd', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'john@example.com', 'https://picsum.photos/seed/u2/200'),
  (3, 'Maria Gomez', 'maria_g', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'maria@example.com', 'https://picsum.photos/seed/u3/200'),
  (4, 'Leo Nakamura', 'leo3d', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'leo@example.com', 'https://picsum.photos/seed/u4/200'),
  (5, 'Chloe Bennett', 'chloeb', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'chloe@example.com', 'https://picsum.photos/seed/u5/200'),
  (6, 'Ethan Ford', 'ethanf', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'ethan@example.com', 'https://picsum.photos/seed/u6/200'),
  (7, 'Zara Khan', 'zarak', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'zara@example.com', 'https://picsum.photos/seed/u7/200'),
  (8, 'Noah Miller', 'noahm', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'noah@example.com', 'https://picsum.photos/seed/u8/200');

-- Insert Clients
INSERT INTO Client (clientId, isAdmin) VALUES
  (1,1),
  (2,0),
  (3,0),
  (4,0),
  (5,0),
  (6,0),
  (7,0),
  (8,0);

-- Insert Artists
INSERT INTO Artist (artistId, rating, category, description) VALUES
  (1, 4.5, 'Character Art', 'Freelance character artist with 5+ years experience.'),
  (3, 4.2, 'Logo Design', 'Specialized in minimalistic and modern logo designs.'),
  (4, 4.8, '3D Modeling', '3D modeler for games and animation.'),
  (5, 4.0, 'Digital Illustration', 'Conceptual illustrations and book covers.');

-- Insert Services
INSERT INTO Service (serviceId, cost, image, artistId, serviceName, rating, category, requests, description, avgTime) VALUES
  (1, 50.0, 'https://picsum.photos/seed/s1/400', 1, 'Custom Character Portrait', 4.5, 'Character Art', 10, 'Unique portraits for your RPG or book characters.', 3.0),
  (2, 80.0, 'https://picsum.photos/seed/s2/400', 3, 'Minimal Logo Design', 4.2, 'Logo Design', 7, 'Clean, timeless logo design for your brand.', 2.0),
  (3, 120.0, 'https://picsum.photos/seed/s3/400', 4, 'Stylized 3D Avatar', 4.8, '3D Modeling', 5, 'Custom stylized 3D characters for games.', 4.5),
  (4, 65.0, 'https://picsum.photos/seed/s4/400', 5, 'Book Cover Illustration', 4.0, 'Digital Illustration', 8, 'Full-color digital book covers for all genres.', 3.5),
  (5, 90.0, 'https://picsum.photos/seed/s5/400', 1, 'Fantasy Character Sheet', 4.7, 'Character Art', 6, 'Detailed full-body character sheets with poses and equipment.', 4.0),
  (6, 70.0, 'https://picsum.photos/seed/s6/400', 3, 'Animated Logo Reveal', 4.6, 'Logo Design', 5, 'Short animated intro for your brand or YouTube channel.', 2.5),
  (7, 150.0, 'https://picsum.photos/seed/s7/400', 4, '3D Environment Prop', 4.9, '3D Modeling', 4, 'Game-ready props or small scenes for stylized environments.', 5.0),
  (8, 55.0, 'https://picsum.photos/seed/s8/400', 5, 'Social Media Banner Art', 4.3, 'Digital Illustration', 7, 'Custom banners for Twitch, YouTube, or Twitter.', 3.0);

INSERT INTO Service (serviceId, cost, image, artistId, serviceName, rating, category, requests, description, avgTime) VALUES
  (9, 95.0, 'https://picsum.photos/seed/s9/400', 1, 'Chibi Character Art', 4.6, 'Character Art', 0, 'Cute and expressive chibi-style character drawings.', 2.5),
  (10, 110.0, 'https://picsum.photos/seed/s10/400', 3, 'Vintage Logo Design', 4.1, 'Logo Design', 0, 'Elegant retro-style logos inspired by vintage aesthetics.', 3.0),
  (11, 200.0, 'https://picsum.photos/seed/s11/400', 4, '3D Creature Sculpt', 4.7, '3D Modeling', 0, 'High-detail sculpting of fantasy or sci-fi creatures.', 6.0),
  (12, 75.0, 'https://picsum.photos/seed/s12/400', 5, 'Comic Panel Illustration', 4.4, 'Digital Illustration', 0, 'Custom comic-style panels with dynamic storytelling.', 4.0);

-- Insert Reviews
INSERT INTO Review (comment, rating, clientId, serviceId, date) VALUES
  ('Amazing detail and expression!', 5, 2, 1, '2024-12-12'),
  ('Captured my DnD character perfectly!', 4, 6, 1, '2024-12-15'),

  ('Nice and professional.', 4, 7, 2, '2025-01-10'),
  ('Good value for money.', 5, 8, 2, '2025-01-12'),

  ('Outstanding modeling skills.', 5, 6, 3, '2025-02-02'),
  ('Will hire again!', 5, 7, 3, '2025-02-06'),

  ('Nice but took a bit long.', 3, 2, 4, '2025-03-01'),
  ('Loved the final result!', 4, 8, 4, '2025-03-04'),

  ('Beautiful and super detailed work.', 5, 6, 5, '2025-03-12'),
  ('Exactly what I needed for my campaign!', 4, 8, 5, '2025-03-15'),

  ('Great animation and branding impact.', 5, 2, 6, '2025-03-20'),
  ('Smooth and eye-catching.', 4, 7, 6, '2025-03-22'),

  ('The prop looked stunning in Unreal Engine!', 5, 6, 7, '2025-04-01'),
  ('Very professional and responsive.', 5, 8, 7, '2025-04-03'),

  ('Cool banner! Very aesthetic.', 4, 2, 8, '2025-04-07'),
  ('Colors and layout were perfect.', 4, 7, 8, '2025-04-09');

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