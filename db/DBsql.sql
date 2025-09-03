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
    calificacion NUMERIC(5,2),
    foto BYTEA

);

CREATE TABLE teachers (
    id SERIAL PRIMARY KEY,
    user_id INT UNIQUE REFERENCES users(id) ON DELETE CASCADE,
    programa VARCHAR(100),
    especialidad VARCHAR(100)
);

CREATE OR REPLACE PROCEDURE CreateUser(
    p_name VARCHAR,
    p_email VARCHAR,
    p_password TEXT
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO users (name, email, pass)
    VALUES (p_name, p_email, p_password);
END;
$$;



CREATE OR REPLACE PROCEDURE CreateStudent(
    p_name VARCHAR,
    p_email VARCHAR,
    p_password TEXT,
    p_programa VARCHAR,
    p_calificacion NUMERIC,
    p_foto BYTEA DEFAULT NULL
)
LANGUAGE plpgsql
AS $$
DECLARE
    new_user_id INT;
BEGIN
    INSERT INTO users (name, email, pass, role)
    VALUES (p_name, p_email, p_password, 'alumno')
    RETURNING id INTO new_user_id;

    INSERT INTO studens (user_id, programa, calificacion, foto)
    VALUES (new_user_id, p_programa, p_calificacion, p_foto);
END;
$$;

CREATE OR REPLACE PROCEDURE CreateTeacher(
    p_name VARCHAR,
    p_email VARCHAR,
    p_password TEXT,
    p_programa VARCHAR,
    p_especialidad VARCHAR
)
LANGUAGE plpgsql
AS $$
DECLARE
    new_user_id INT;
BEGIN
    INSERT INTO users (name, email, pass, role)
    VALUES (p_name, p_email, p_password, 'profesor')
    RETURNING id INTO new_user_id;

    INSERT INTO teachers (user_id, programa, especialidad)
    VALUES (new_user_id, p_programa, p_especialidad);
END;
$$;
