-- SQLite
CREATE TABLE users (
    id INTEGER PRIMARY KEY,
    name TEXT,
    email TEXT UNIQUE
);
INSERT INTO users (name, email)
VALUES ('John Doe', 'john@example.com'),
    ('Delia Marilyne', 'delia@gmail.com'),
    ('Victoria', 'victoria@gmail.com');


    CREATE TABLE students (
    id INTEGER PRIMARY KEY,
    name TEXT,
    age INTEGER,
    grade TEXT
);
