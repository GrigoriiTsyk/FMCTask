--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3
-- Dumped by pg_dump version 15.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: valute; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.valute (
    id character varying(100) NOT NULL,
    numcode character varying(100),
    charcode character varying(100),
    nominal integer,
    name character varying(100),
    value real,
    vunitrate real
);


ALTER TABLE public.valute OWNER TO postgres;

--
-- Data for Name: valute; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.valute (id, numcode, charcode, nominal, name, value, vunitrate) FROM stdin;
\.


--
-- Name: valute valute_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.valute
    ADD CONSTRAINT valute_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

