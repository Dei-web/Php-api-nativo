CREATE TYPE user_role AS ENUM ('admin', 'profesor', 'alumno');

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL ,
    email VARCHAR(255) NOT NULL UNIQUE,
    pass TEXT NOT NULL,
    role user_role NOT NULL DEFAULT 'alumno'
);

CREATE TABLE studens (
    id SERIAL PRIMARY KEY,
    user_id INT UNIQUE REFERENCES users(id) ON DELETE CASCADE,
    programa VARCHAR(100) NOT NULL,
    calificacion NUMERIC(5,2)
);

CREATE TABLE theacher (
    id SERIAL PRIMARY KEY,
    user_id INT UNIQUE REFERENCES users(id) ON DELETE CASCADE,
    programa VARCHAR(100),
    especialidad VARCHAR(100)
);

CREATE OR REPLACE PROCEDURE(
    p_name VARCHAR,
    p_email VARCHAR,
    p_password TEXT
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO users (name, email, password)
    VALUES (p_name, p_email, p_password);
END;
$$;
