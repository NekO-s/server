--
-- PostgreSQL database dump
--

-- Dumped from database version 11.5 (Ubuntu 11.5-1.pgdg18.04+1)
-- Dumped by pg_dump version 11.5 (Ubuntu 11.5-1.pgdg18.04+1)

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

SET default_with_oids = false;

--
-- Name: url; Type: TABLE; Schema: public; Owner: 
--

CREATE TABLE public.url (
    id bigint NOT NULL,
    url character varying(150) NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.url OWNER TO ;

--
-- Name: url_id_seq; Type: SEQUENCE; Schema: public; Owner: 
--

CREATE SEQUENCE public.url_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.url_id_seq OWNER TO ;

--
-- Name: url_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: 
--

ALTER SEQUENCE public.url_id_seq OWNED BY public.url.id;


--
-- Name: url id; Type: DEFAULT; Schema: public; Owner: 
--

ALTER TABLE ONLY public.url ALTER COLUMN id SET DEFAULT nextval('public.url_id_seq'::regclass);


--
-- Data for Name: url; Type: TABLE DATA; Schema: public; Owner: 
--

COPY public.url (id, url, created_at) FROM stdin;
1	https://yandex.ru/	1577741494
3	https://yandex.ru/	1577741652
4	https://yandex.ru/	1577741693
5	https://yandex.ru/	1577741825
6	https://yandex.ru/	1577741828
7	https://yandex.ru/	1577741885
8	https://yandex.ru/	1577741887
9	https://yandex.ru/	1577741888
10	https://yandex.ru/	1577741888
11	https://yandex.ru/	1577741888
12	https://yandex.ru/	1577741888
13	https://yandex.ru/	1577741888
\.


--
-- Name: url_id_seq; Type: SEQUENCE SET; Schema: public; Owner: 
--

SELECT pg_catalog.setval('public.url_id_seq', 13, true);


--
-- Name: url url_pk; Type: CONSTRAINT; Schema: public; Owner: 
--

ALTER TABLE ONLY public.url
    ADD CONSTRAINT url_pk PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--


