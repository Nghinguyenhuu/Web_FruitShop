--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1
-- Dumped by pg_dump version 16.0

-- Started on 2023-12-16 14:05:59

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

--
-- TOC entry 6 (class 2615 OID 16434)
-- Name: fruit_shop; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA fruit_shop;


ALTER SCHEMA fruit_shop OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 219 (class 1259 OID 16436)
-- Name: cart; Type: TABLE; Schema: fruit_shop; Owner: postgres
--

CREATE TABLE fruit_shop.cart (
    id_order bigint NOT NULL,
    id_user bigint NOT NULL,
    id_item bigint NOT NULL,
    name character varying(255) NOT NULL,
    price double precision NOT NULL,
    quantity bigint NOT NULL
);


ALTER TABLE fruit_shop.cart OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16435)
-- Name: cart_id_order_seq; Type: SEQUENCE; Schema: fruit_shop; Owner: postgres
--

CREATE SEQUENCE fruit_shop.cart_id_order_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE fruit_shop.cart_id_order_seq OWNER TO postgres;

--
-- TOC entry 4860 (class 0 OID 0)
-- Dependencies: 218
-- Name: cart_id_order_seq; Type: SEQUENCE OWNED BY; Schema: fruit_shop; Owner: postgres
--

ALTER SEQUENCE fruit_shop.cart_id_order_seq OWNED BY fruit_shop.cart.id_order;


--
-- TOC entry 221 (class 1259 OID 16441)
-- Name: fruits_table; Type: TABLE; Schema: fruit_shop; Owner: postgres
--

CREATE TABLE fruit_shop.fruits_table (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    image character varying(255) NOT NULL,
    price double precision NOT NULL
);


ALTER TABLE fruit_shop.fruits_table OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16440)
-- Name: fruits_table_id_seq; Type: SEQUENCE; Schema: fruit_shop; Owner: postgres
--

CREATE SEQUENCE fruit_shop.fruits_table_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE fruit_shop.fruits_table_id_seq OWNER TO postgres;

--
-- TOC entry 4861 (class 0 OID 0)
-- Dependencies: 220
-- Name: fruits_table_id_seq; Type: SEQUENCE OWNED BY; Schema: fruit_shop; Owner: postgres
--

ALTER SEQUENCE fruit_shop.fruits_table_id_seq OWNED BY fruit_shop.fruits_table.id;


--
-- TOC entry 223 (class 1259 OID 16448)
-- Name: users; Type: TABLE; Schema: fruit_shop; Owner: postgres
--

CREATE TABLE fruit_shop.users (
    id_user bigint NOT NULL,
    username character varying(50) NOT NULL,
    password character varying(50) NOT NULL,
    avatar character varying(255) DEFAULT 'default.png'::character varying NOT NULL,
    name character varying(40) NOT NULL,
    email character varying(40) NOT NULL,
    phone_number character varying(20) NOT NULL,
    role character varying(10) NOT NULL,
    wallet double precision DEFAULT '0'::double precision NOT NULL,
    vip_end date
);


ALTER TABLE fruit_shop.users OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16447)
-- Name: users_id_user_seq; Type: SEQUENCE; Schema: fruit_shop; Owner: postgres
--

CREATE SEQUENCE fruit_shop.users_id_user_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE fruit_shop.users_id_user_seq OWNER TO postgres;

--
-- TOC entry 4862 (class 0 OID 0)
-- Dependencies: 222
-- Name: users_id_user_seq; Type: SEQUENCE OWNED BY; Schema: fruit_shop; Owner: postgres
--

ALTER SEQUENCE fruit_shop.users_id_user_seq OWNED BY fruit_shop.users.id_user;


--
-- TOC entry 4701 (class 2604 OID 16439)
-- Name: cart id_order; Type: DEFAULT; Schema: fruit_shop; Owner: postgres
--

ALTER TABLE ONLY fruit_shop.cart ALTER COLUMN id_order SET DEFAULT nextval('fruit_shop.cart_id_order_seq'::regclass);


--
-- TOC entry 4702 (class 2604 OID 16444)
-- Name: fruits_table id; Type: DEFAULT; Schema: fruit_shop; Owner: postgres
--

ALTER TABLE ONLY fruit_shop.fruits_table ALTER COLUMN id SET DEFAULT nextval('fruit_shop.fruits_table_id_seq'::regclass);


--
-- TOC entry 4703 (class 2604 OID 16451)
-- Name: users id_user; Type: DEFAULT; Schema: fruit_shop; Owner: postgres
--

ALTER TABLE ONLY fruit_shop.users ALTER COLUMN id_user SET DEFAULT nextval('fruit_shop.users_id_user_seq'::regclass);


--
-- TOC entry 4850 (class 0 OID 16436)
-- Dependencies: 219
-- Data for Name: cart; Type: TABLE DATA; Schema: fruit_shop; Owner: postgres
--

COPY fruit_shop.cart (id_order, id_user, id_item, name, price, quantity) FROM stdin;
1	2	1	Apple	3	53
2	2	2	Orange	4	1
21	8	5	Waterlemon	7	30
\.


--
-- TOC entry 4852 (class 0 OID 16441)
-- Dependencies: 221
-- Data for Name: fruits_table; Type: TABLE DATA; Schema: fruit_shop; Owner: postgres
--

COPY fruit_shop.fruits_table (id, name, image, price) FROM stdin;
1	Apple	apple.jpg	3
2	Orange	orange.jpg	4
3	Banana	banana.jpg	5
4	Lemon	lemon.jpg	3.5
5	Waterlemon	waterlemon.jpg	7
6	Cherry	cherry.jpg	4
8	Grape	grape.jpg	3
10	Durian	durian.jpg	11
\.


--
-- TOC entry 4854 (class 0 OID 16448)
-- Dependencies: 223
-- Data for Name: users; Type: TABLE DATA; Schema: fruit_shop; Owner: postgres
--

COPY fruit_shop.users (id_user, username, password, avatar, name, email, phone_number, role, wallet, vip_end) FROM stdin;
2	naruto2	827ccb0eea8a706c4c34a16891f84e7b	default.png				user	0	\N
4	admin	0192023a7bbd73250516f069df18b500	default.png				admin	9000	\N
5	test	cc03e747a6afbbcbf8be7668acfebee5	default.png				user	0	\N
7	naruto	827ccb0eea8a706c4c34a16891f84e7b	default.png	naruto2	naruto@naruto	12345678	VIP	10000	2022-12-17
8	naruto3	884ecc7ac05cb5d52aa970f523a3b7e6	default.png		hokage@hokage2	12345678	user	1000	\N
13	naruanru	827ccb0eea8a706c4c34a16891f84e7b	default.png	naruanru	naruanru@33.com	12345678999	user	0	\N
\.


--
-- TOC entry 4863 (class 0 OID 0)
-- Dependencies: 218
-- Name: cart_id_order_seq; Type: SEQUENCE SET; Schema: fruit_shop; Owner: postgres
--

SELECT pg_catalog.setval('fruit_shop.cart_id_order_seq', 21, true);


--
-- TOC entry 4864 (class 0 OID 0)
-- Dependencies: 220
-- Name: fruits_table_id_seq; Type: SEQUENCE SET; Schema: fruit_shop; Owner: postgres
--

SELECT pg_catalog.setval('fruit_shop.fruits_table_id_seq', 10, true);


--
-- TOC entry 4865 (class 0 OID 0)
-- Dependencies: 222
-- Name: users_id_user_seq; Type: SEQUENCE SET; Schema: fruit_shop; Owner: postgres
--

SELECT pg_catalog.setval('fruit_shop.users_id_user_seq', 13, true);


-- Completed on 2023-12-16 14:05:59

--
-- PostgreSQL database dump complete
--

