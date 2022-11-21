-- Adminer 4.8.1 PostgreSQL 13.3 (Debian 13.3-1.pgdg100+1) dump

\connect "postgres";

DROP TABLE IF EXISTS "students";
DROP SEQUENCE IF EXISTS students_id_seq;
CREATE SEQUENCE students_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."students" (
    "id" bigint DEFAULT nextval('students_id_seq') NOT NULL,
    "group" integer,
    "name" text NOT NULL,
    "credit1" boolean,
    "credit2" boolean,
    "credit3" boolean,
    "credit4" boolean,
    "credit5" boolean,
    "exam1" integer,
    "exam2" integer,
    "exam3" integer,
    "exam4" integer,
    "exam5" integer,
    "record_status" record_st DEFAULT ACTIVE NOT NULL,
    CONSTRAINT "students_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "students" ("id", "group", "name", "credit1", "credit2", "credit3", "credit4", "credit5", "exam1", "exam2", "exam3", "exam4", "exam5", "record_status") VALUES
(2,	213009,	'Petrov Ivan Ivanovich',	'1',	'0',	'1',	'1',	'1',	6,	6,	7,	8,	7,	'ACTIVE'),
(3,	213009,	'Ivanov Petr Ptrovich',	'1',	'0',	'1',	'0',	'1',	10,	8,	9,	8,	6,	'ACTIVE'),
(1,	213009,	'Tokarev Timophey Vladimirovich',	'1',	'0',	'1',	'1',	'0',	4,	9,	8,	7,	8,	'ACTIVE');

DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."users" (
    "id" bigint DEFAULT nextval('users_id_seq') NOT NULL,
    "name" text NOT NULL,
    "role" role DEFAULT USER NOT NULL,
    "password_hash" text NOT NULL,
    "record_status" record_st DEFAULT ACTIVE NOT NULL,
    CONSTRAINT "users_name_key" UNIQUE ("name"),
    CONSTRAINT "users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "users" ("id", "name", "role", "password_hash", "record_status") VALUES
(1,	'admin',	'ADMIN',	'$2y$13$kYPIII6pwlPyxpbhmJpt9eQFHRoksBG3w9A79SYJBnp8mGHIZShEW',	'ACTIVE'),
(2,	'user',	'USER',	'$2y$13$AK52DSXuwtDp8IPp/HJk/u/UcLSXZnQBoQvi2KXqwTF2ekrvNWjji',	'ACTIVE');

-- 2022-11-21 20:57:24.275777+00