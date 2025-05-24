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
    email VARCHAR(255) NOT NULL UNIQUE,
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

INSERT INTO Category (name) VALUES
  ('Digital Illustration'),
  ('Logo Design'),
  ('3D Modeling'),
  ('Character Art'),
  ('Concept Art'),
  ('Pixel Art'),
  ('UI/UX Design'),
  ('Storyboarding'),
  ('NFT Art'),
  ('Photo Editing');

INSERT INTO Users (id, fullname, username, password, email, profileP) VALUES
  (1, 'Alice Carter', 'alicec', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'alice@example.com', 'https://picsum.photos/seed/u1/200'),
  (2, 'John Doe', 'johnd', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'john@example.com', 'https://picsum.photos/seed/u2/200'),
  (3, 'Maria Gomez', 'maria_g', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'maria@example.com', 'https://picsum.photos/seed/u3/200'),
  (4, 'Leo Nakamura', 'leo3d', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'leo@example.com', 'https://picsum.photos/seed/u4/200'),
  (5, 'Chloe Bennett', 'chloeb', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'chloe@example.com', 'https://picsum.photos/seed/u5/200'),
  (6, 'Ethan Ford', 'ethanf', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'ethan@example.com', 'https://picsum.photos/seed/u6/200'),
  (7, 'Zara Khan', 'zarak', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'zara@example.com', 'https://picsum.photos/seed/u7/200'),
  (8, 'Noah Miller', 'noahm', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'noah@example.com', 'https://picsum.photos/seed/u8/200'),
  (9, 'Sophia Martinez', 'smartinez', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'sophia.martinez@example.com', 'https://picsum.photos/seed/u9/200'),
  (10, 'Liam Johnson', 'ljohnson', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'liam.johnson@example.com', 'https://picsum.photos/seed/u10/200'),
  (11, 'Emma Brown', 'ebrown', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'emma.brown@example.com', 'https://picsum.photos/seed/u11/200'),
  (12, 'Noah Davis', 'ndavis', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'noah.davis@example.com', 'https://picsum.photos/seed/u12/200'),
  (13, 'Isabella Garcia', 'igarcia', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'isabella.garcia@example.com', 'https://picsum.photos/seed/u13/200'),
  (14, 'Mason Rodriguez', 'mrodriguez', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'mason.rodriguez@example.com', 'https://picsum.photos/seed/u14/200'),
  (15, 'Mia Wilson', 'mwilson', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'mia.wilson@example.com', 'https://picsum.photos/seed/u15/200'),
  (16, 'James Anderson', 'janderson', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'james.anderson@example.com', 'https://picsum.photos/seed/u16/200'),
  (17, 'Charlotte Thomas', 'cthomas', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'charlotte.thomas@example.com', 'https://picsum.photos/seed/u17/200'),
  (18, 'Benjamin Lee', 'blee', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'benjamin.lee@example.com', 'https://picsum.photos/seed/u18/200'),
  (19, 'Amelia Harris', 'aharris', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'amelia.harris@example.com', 'https://picsum.photos/seed/u19/200'),
  (20, 'Elijah Clark', 'eclark', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'elijah.clark@example.com', 'https://picsum.photos/seed/u20/200'),
  (21, 'Olivia Lewis', 'olewis', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'olivia.lewis@example.com', 'https://picsum.photos/seed/u21/200'),
  (22, 'William Walker', 'wwalker', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'william.walker@example.com', 'https://picsum.photos/seed/u22/200'),
  (23, 'Ava Hall', 'avah', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'ava.hall@example.com', 'https://picsum.photos/seed/u23/200'),
  (24, 'Henry Young', 'hyoung', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'henry.young@example.com', 'https://picsum.photos/seed/u24/200'),
  (25, 'Sophie Allen', 'sallen', '$2y$10$2527Mlw9AgMDwFBr.7sDFOnaZiNmi23cjOlRYLIUhu6.2fp95.bfW', 'sophie.allen@example.com', 'https://picsum.photos/seed/u25/200');

INSERT INTO Client (clientId, isAdmin) VALUES
  (1,1), (2,0), (3,0), (4,0), (5,0), (6,0), (7,0), (8,0),
  (9,1), (10,0), (11,1), (12,0), (13,0), (14,0), (15,1),
  (16,0), (17,1), (18,0), (19,1), (20,0), (21,0), (22,1),
  (23,0), (24,1), (25,0);

INSERT INTO Artist (artistId, rating, category, description) VALUES
  (1, 4.5, 'Character Art', 'Freelance character artist specializing in fantasy and sci-fi designs with 5+ years experience. Worked with major game studios and indie developers.'),
  (3, 4.2, 'Logo Design', 'Award-winning logo designer with a minimalist approach. Specialized in modern, clean designs that communicate brand identity effectively.'),
  (4, 4.8, '3D Modeling', 'Professional 3D modeler for games and animation with expertise in both realistic and stylized assets. Proficient in Blender, Maya, and ZBrush.'),
  (5, 4.0, 'Digital Illustration', 'Digital artist creating conceptual illustrations and book covers. Strong narrative focus with vibrant color palettes.'),
  (9, 4.3, 'Pixel Art', 'Pixel artist creating retro-style game assets and animations. Passionate about the 16-bit aesthetic and modern pixel art techniques.'),
  (11, 4.7, '3D Modeling', 'Technical 3D artist specializing in hard-surface modeling for industrial visualization and product design.'),
  (13, 4.1, 'Concept Art', 'Concept artist with experience in film and video game pre-production. Strong environmental design skills.'),
  (15, 3.9, 'Logo Design', 'Versatile logo designer with expertise in vintage, modern, and abstract styles. Focus on brand storytelling.'),
  (17, 4.6, 'Digital Illustration', 'Illustrator specializing in children''s books and educational materials. Whimsical style with educational focus.'),
  (19, 4.4, 'Character Art', 'Character artist with anime-inspired style. Specializes in emotive portraits and dynamic action poses.'),
  (21, 4.2, 'UI/UX Design', 'UI/UX designer creating intuitive interfaces for games and apps. Strong focus on user experience.'),
  (23, 3.8, 'Storyboarding', 'Storyboard artist with animation studio experience. Skilled at visual storytelling and composition.');

INSERT INTO Service (serviceId, cost, image, artistId, serviceName, rating, category, requests, description, avgTime) VALUES
  (1, 50.0, 'https://picsum.photos/seed/s1/400', 1, 'Custom Character Portrait', 4.5, 'Character Art', 12, 'Bust or waist-up portrait of your original character with detailed rendering. Includes 2 revisions and multiple file formats (PNG, JPG, PSD). Perfect for social media avatars or reference sheets.', 3.0),
  (2, 80.0, 'https://picsum.photos/seed/s2/400', 3, 'Minimal Logo Design', 4.2, 'Logo Design', 8, 'Clean, timeless logo design with 3 initial concepts. Final delivery includes vector files (AI, EPS), high-res PNG, and brand color palette.', 2.0),
  (3, 120.0, 'https://picsum.photos/seed/s3/400', 4, 'Stylized 3D Avatar', 4.8, '3D Modeling', 6, 'Custom stylized 3D character model optimized for games (Unity/Unreal ready). Includes textures and basic rigging.', 4.5),
  (4, 65.0, 'https://picsum.photos/seed/s4/400', 5, 'Book Cover Illustration', 4.0, 'Digital Illustration', 9, 'Full-color digital book cover with title treatment. Print-ready 300dpi files with bleed. Perfect for indie authors.', 3.5),
  (5, 90.0, 'https://picsum.photos/seed/s5/400', 1, 'Fantasy Character Sheet', 4.7, 'Character Art', 7, 'Detailed character reference sheet with front/back views, expressions, and equipment. Ideal for game developers or authors.', 4.0),
  (6, 70.0, 'https://picsum.photos/seed/s6/400', 3, 'Animated Logo Reveal', 4.6, 'Logo Design', 6, '5-second animated logo intro (MP4, MOV) with sound effects. Perfect for YouTube channels or business presentations.', 2.5),
  (7, 150.0, 'https://picsum.photos/seed/s7/400', 4, '3D Environment Prop', 4.9, '3D Modeling', 5, 'Game-ready 3D prop with PBR textures. Optimized for real-time rendering with LODs included.', 5.0),
  (8, 55.0, 'https://picsum.photos/seed/s8/400', 5, 'Social Media Banner Art', 4.3, 'Digital Illustration', 8, 'Custom banners sized for Twitch, YouTube, or Twitter. Includes layered PSD for easy updates.', 3.0),
  (9, 95.0, 'https://picsum.photos/seed/s9/400', 9, 'Pixel Art Character Sprite', 4.6, 'Pixel Art', 4, 'Custom 32x32 or 64x64 pixel character sprite with 4-direction animation (idle, walk cycles).', 2.5),
  (10, 110.0, 'https://picsum.photos/seed/s10/400', 11, 'Product 3D Visualization', 4.5, '3D Modeling', 3, 'Photorealistic 3D product render with 3 camera angles. Ideal for e-commerce or crowdfunding campaigns.', 3.0),
  (11, 200.0, 'https://picsum.photos/seed/s11/400', 13, 'World Concept Package', 4.7, 'Concept Art', 2, 'Complete worldbuilding concept with key locations, props, and mood boards. Perfect for game pre-production.', 6.0),
  (12, 75.0, 'https://picsum.photos/seed/s12/400', 15, 'Vintage Badge Logo', 4.2, 'Logo Design', 5, 'Handcrafted vintage-style badge logo with distressed textures. Includes monochrome versions.', 4.0),
  (13, 85.0, 'https://picsum.photos/seed/s13/400', 17, 'Children''s Book Spread', 4.4, 'Digital Illustration', 3, 'Full two-page spread illustration with text placement guides. Consistent with your story''s theme.', 3.0),
  (14, 120.0, 'https://picsum.photos/seed/s14/400', 19, 'Anime Character Commission', 4.3, 'Character Art', 4, 'Full-body anime-style character with simple background. High-res files suitable for printing.', 4.0),
  (15, 180.0, 'https://picsum.photos/seed/s15/400', 21, 'Mobile App UI Kit', 4.8, 'UI/UX Design', 2, 'Complete UI design system for mobile apps including components, icons, and style guide.', 5.0),
  (16, 90.0, 'https://picsum.photos/seed/s16/400', 23, 'Storyboard Sequence', 4.1, 'Storyboarding', 1, '10-panel storyboard with shot composition notes. Ideal for film pre-visualization.', 3.5),
  (17, 60.0, 'https://picsum.photos/seed/s17/400', 9, 'Pixel Art Tile Set', 4.5, 'Pixel Art', 2, '16x16 or 32x32 pixel environment tiles for 2D games. Includes variations for natural transitions.', 4.0),
  (18, 250.0, 'https://picsum.photos/seed/s18/400', 11, 'Architectural Visualization', 4.9, '3D Modeling', 1, 'High-end architectural render with realistic lighting and materials. Perfect for presentations.', 7.0),
  (19, 70.0, 'https://picsum.photos/seed/s19/400', 15, 'Mascot Logo Design', 4.4, 'Logo Design', 3, 'Playful mascot logo perfect for esports teams or youth brands. Includes multiple expressions.', 3.0),
  (20, 95.0, 'https://picsum.photos/seed/s20/400', 19, 'Chibi Character Set', 4.6, 'Character Art', 2, 'Set of 3 chibi-style characters with matching color schemes. Great for merch or social media.', 3.5);

INSERT INTO Request (requestId, description, clientId, serviceId, status, date) VALUES
  (1, 'Need a portrait for my elf sorcerer with blue magic effects.', 2, 1, 'COMPLETE', '2024-12-10'),
  (2, 'Company rebranding project for tech startup. Want minimalist geometric design.', 7, 2, 'COMPLETE', '2025-01-09'),
  (3, 'Game-ready 3D model of sci-fi hero with armor and energy weapon.', 6, 3, 'PENDING', '2025-02-01'),
  (4, 'Romance novel cover with couple in forest at sunset.', 8, 4, 'COMPLETE', '2025-03-02'),
  (5, 'Character sheet for elf mage with staff and spellbook.', 6, 5, 'PENDING', '2025-03-10'),
  (6, 'Animated logo for gaming YouTube channel (space theme).', 2, 6, 'COMPLETE', '2025-03-18'),
  (7, 'Forest crate models (3 variations) for puzzle game.', 8, 7, 'PENDING', '2025-04-02'),
  (8, 'Twitter header with galaxy theme for astronomy account.', 7, 8, 'COMPLETE', '2025-04-05'),
  (9, '16-bit style pixel art protagonist for retro platformer.', 10, 9, 'COMPLETE', '2025-04-12'),
  (10, '3D render of smartwatch product for Kickstarter campaign.', 12, 10, 'PENDING', '2025-04-15'),
  (11, 'Post-apocalyptic city concept for graphic novel.', 14, 11, 'PENDING', '2025-04-18'),
  (12, 'Vintage brewery logo with hops and barrel motifs.', 16, 12, 'COMPLETE', '2025-04-20'),
  (13, 'Children''s book spread of underwater scene with mermaids.', 18, 13, 'COMPLETE', '2025-04-22'),
  (14, 'Anime OC commission with cherry blossom background.', 20, 14, 'PENDING', '2025-04-25'),
  (15, 'Fitness app UI design with workout tracking features.', 22, 15, 'PENDING', '2025-04-28'),
  (16, 'Storyboard for short film opening sequence (5 pages).', 24, 16, 'COMPLETE', '2025-05-01'),
  (17, 'Pixel art tileset for fantasy RPG (forest/castle themes).', 10, 17, 'PENDING', '2025-05-05'),
  (18, 'Architectural render of modern beach house interior.', 12, 18, 'PENDING', '2025-05-08'),
  (19, 'Esports team mascot (shark theme with aggressive look).', 14, 19, 'COMPLETE', '2025-05-12'),
  (20, 'Chibi versions of our D&D party (4 characters).', 16, 20, 'COMPLETE', '2025-05-15');

INSERT INTO Review (comment, rating, clientId, serviceId, date) VALUES
  ('Absolutely stunning portrait! Captured my character''s personality perfectly.', 5, 2, 1, '2024-12-12'),
  ('Great artist to work with. Minor revision needed but very professional.', 4, 6, 1, '2024-12-15'),
  ('Logo exceeded expectations. Will use for all future projects!', 5, 7, 2, '2025-01-10'),
  ('Good communication and quick turnaround.', 4, 8, 2, '2025-01-12'),
  ('Model looks incredible in our game engine. Highly recommend!', 5, 6, 3, '2025-02-02'),
  ('Perfect for our indie game. Will definitely commission again.', 5, 7, 3, '2025-02-06'),
  ('Beautiful artwork but delivery was a week late.', 3, 2, 4, '2025-03-01'),
  ('Cover increased our book sales immediately!', 4, 8, 4, '2025-03-04'),
  ('Detailed character sheet that helped our animators immensely.', 5, 6, 5, '2025-03-12'),
  ('Minor issues with file formats but excellent art.', 4, 8, 5, '2025-03-15'),
  ('Animation made our channel look so professional!', 5, 2, 6, '2025-03-20'),
  ('Great work but had to request one revision.', 4, 7, 6, '2025-03-22'),
  ('Props integrated perfectly with our game environment.', 5, 6, 7, '2025-04-01'),
  ('Artist understood exactly what we needed.', 5, 8, 7, '2025-04-03'),
  ('Banner increased our follower engagement by 30%!', 4, 2, 8, '2025-04-07'),
  ('Quick delivery and exactly as described.', 4, 7, 8, '2025-04-09'),
  ('Pixel art has that perfect retro charm we wanted.', 5, 10, 9, '2025-04-14'),
  ('Product render looks photorealistic! Helped our campaign succeed.', 5, 12, 10, '2025-04-17'),
  ('Concept art gave us exactly the visual direction we needed.', 4, 14, 11, '2025-04-20'),
  ('Logo has that authentic vintage feel we were after.', 5, 16, 12, '2025-04-23');

INSERT INTO CustomService (Cname, CserviceId, description, clientId, artistId, cost, image, status, date) VALUES
  ('Custom Comic Book Cover', 1, 'Front and back cover for indie comic series with specific characters', 3, 5, 150.0, 'https://picsum.photos/seed/cs1/400', 'PENDING', '2025-01-15'),
  ('VR Game UI Elements', 2, 'Custom UI kit for VR rhythm game with neon aesthetics', 5, 21, 300.0, 'https://picsum.photos/seed/cs2/400', 'PENDING', '2025-02-20'),
  ('Animated NFT Collection', 3, 'Series of 10 animated pixel art characters for NFT project', 9, 9, 1200.0, 'https://picsum.photos/seed/cs3/400', 'PENDING', '2025-03-10'),
  ('Restaurant Mural Design', 4, 'Large-scale mural design for Mexican restaurant interior', 11, 13, 450.0, 'https://picsum.photos/seed/cs4/400', 'PENDING', '2025-04-05'),
  ('Board Game Illustration Set', 5, 'Complete art package for fantasy board game (50+ assets)', 15, 17, 2500.0, 'https://picsum.photos/seed/cs5/400', 'PENDING', '2025-05-01');

INSERT INTO Message (id, senderId, serviceId, receiverId, requestId, message, timestamp) VALUES
  (1, 2, 1, 1, 1, 'Hi! I''d like a portrait of my elf sorcerer with blue magic effects. She has silver hair and purple eyes.', '2024-12-10 09:15:23'),
  (2, 1, 1, 2, 1, 'Sounds great! Do you have any reference images for her appearance?', '2024-12-10 10:02:45'),
  (3, 2, 1, 1, 1, 'Yes, I''ll send some sketches. She wears a hooded cloak with celestial patterns.', '2024-12-10 11:30:12'),
  (4, 1, 1, 2, 1, 'Received them. I''ll send a sketch in 2 days for approval.', '2024-12-10 12:45:00'),
  (5, 6, 3, 4, 3, 'We need a sci-fi hero model for our game. Think futuristic armor with glowing elements.', '2025-02-01 14:20:33'),
  (6, 4, 3, 6, 3, 'Got it. Should the armor be more mechanical or organic in style?', '2025-02-01 15:05:17'),
  (7, 6, 3, 4, 3, 'Mechanical with some curved panels. Our art director will send concept art.', '2025-02-01 16:12:48'),
  (8, 8, 7, 4, 7, 'Need 3 variations of forest crates for our puzzle game. Wooden with metal reinforcements.', '2025-04-02 10:45:22'),
  (9, 4, 7, 8, 7, 'Understood. What polycount range should I target?', '2025-04-02 11:30:05'),
  (10, 8, 7, 4, 7, 'Keep under 5k tris each. We''re targeting mobile devices.', '2025-04-02 13:15:41'),
  (11, 4, 7, 8, 7, 'First model draft sent for review. Check your email.', '2025-04-05 09:00:15'),
  (12, 12, 10, 11, 10, 'We need photorealistic renders of our smartwatch for Kickstarter.', '2025-04-15 08:30:00'),
  (13, 11, 10, 12, 10, 'Do you have the 3D CAD files or should I model from scratch?', '2025-04-15 09:45:33'),
  (14, 12, 10, 11, 10, 'We''ll send STEP files. Need 3 angles showing the interface.', '2025-04-15 11:20:17'),
  (19, 20, 14, 19, 14, 'Want an anime OC with cherry blossoms. She''s a shrine maiden.', '2025-04-25 12:30:45'),
  (20, 19, 14, 20, 14, 'Cute concept! Any specific pose or expression?', '2025-04-25 13:15:22'),
  (21, 20, 14, 19, 14, 'Peaceful expression, holding a sacred mirror. Pink color theme.', '2025-04-25 14:30:10'),
  (22, 19, 14, 20, 14, 'Sketch sent for approval. Let me know if you want changes.', '2025-04-27 09:45:33');