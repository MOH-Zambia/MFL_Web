--
-- PostgreSQL database dump
--

-- Dumped from database version 13.1 (Ubuntu 13.1-1.pgdg20.04+1)
-- Dumped by pg_dump version 13.1 (Ubuntu 13.1-1.pgdg20.04+1)

-- Started on 2021-04-06 12:19:26 CAT

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
-- TOC entry 205 (class 1259 OID 51431)
-- Name: data_element_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.data_element_group (
    id integer NOT NULL,
    name character varying NOT NULL,
    description character varying
);


ALTER TABLE public.data_element_group OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 51429)
-- Name: data_element_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.data_element_group ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.data_element_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 207 (class 1259 OID 51441)
-- Name: data_elements; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.data_elements (
    id integer NOT NULL,
    element_group_id integer NOT NULL,
    uid character varying NOT NULL,
    name character varying NOT NULL,
    short_name character varying NOT NULL,
    code character varying NOT NULL,
    definition character varying,
    aggregation_type character varying,
    domain_type character varying,
    description character varying,
    definition_extended character varying,
    use_and_context character varying,
    inclusions character varying,
    exclusions character varying,
    collected_by character varying,
    collection_point character varying,
    tools character varying,
    keep_zero_values character varying,
    zeroissignificant character varying,
    nids_versions character varying,
    created_at integer,
    created_by integer,
    updated_by integer,
    favorite character varying,
    updated_at integer
);


ALTER TABLE public.data_elements OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 51439)
-- Name: data_elements_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.data_elements ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.data_elements_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 200 (class 1259 OID 51404)
-- Name: indicator_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.indicator_group (
    id integer NOT NULL,
    name character varying NOT NULL,
    description text
);


ALTER TABLE public.indicator_group OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 51420)
-- Name: indicator_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.indicator_group ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.indicator_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 201 (class 1259 OID 51412)
-- Name: indicators; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.indicators (
    id integer NOT NULL,
    uid character varying NOT NULL,
    name character varying NOT NULL,
    short_name character varying NOT NULL,
    code character varying NOT NULL,
    definition character varying,
    indicator_group_id integer NOT NULL,
    numerator_description character varying,
    numerator_formula character varying,
    denominator_description character varying,
    denominator_formula character varying,
    indicator_type character varying,
    annualized character varying,
    use_and_context character varying,
    frequency character varying,
    level character varying,
    favorite character varying,
    nids_versions character varying,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer
);


ALTER TABLE public.indicators OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 51422)
-- Name: indicators_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.indicators ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.indicators_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 211 (class 1259 OID 51466)
-- Name: validation_rule_operator; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.validation_rule_operator (
    id integer NOT NULL,
    name character varying NOT NULL,
    description character varying
);


ALTER TABLE public.validation_rule_operator OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 51464)
-- Name: validation_rule_operator_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.validation_rule_operator ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.validation_rule_operator_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 209 (class 1259 OID 51456)
-- Name: validation_rules; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.validation_rules (
    id integer NOT NULL,
    uid character varying NOT NULL,
    name character varying NOT NULL,
    description character varying,
    left_side character varying,
    right_side character varying,
    type character varying,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer,
    operator integer NOT NULL
);


ALTER TABLE public.validation_rules OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 51454)
-- Name: validation_rules_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.validation_rules ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.validation_rules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 3041 (class 0 OID 51431)
-- Dependencies: 205
-- Data for Name: data_element_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.data_element_group (id, name, description) FROM stdin;
2	DS-TB Quarterly	
3	DR-TB Quarterly	
4	ART Baseline	
5	ART Child Baseline	
\.


--
-- TOC entry 3043 (class 0 OID 51441)
-- Dependencies: 207
-- Data for Name: data_elements; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.data_elements (id, element_group_id, uid, name, short_name, code, definition, aggregation_type, domain_type, description, definition_extended, use_and_context, inclusions, exclusions, collected_by, collection_point, tools, keep_zero_values, zeroissignificant, nids_versions, created_at, created_by, updated_by, favorite, updated_at) FROM stdin;
3	4	QboKglxbVn6	ART adult naive start	ART adult TOT	A_TOT		SUM	AGGREGATE		None	Monitors ART naive clients who started in a facility	New treatment experienced Transferred in	NAIVE adults which: - have never been exposed to ART for more than 30 days in total - are from post-exposure prophylaxis (PEP) programme - are from the dual PMTCT programme 	Clinician & Data capturer	ART site	ART clinical record captured in TIER.Net, SMARTER	true	true	\N	1617538536	14	14	false	1617538946
\.


--
-- TOC entry 3036 (class 0 OID 51404)
-- Dependencies: 200
-- Data for Name: indicator_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.indicator_group (id, name, description) FROM stdin;
3	DS-TB Quarterly	
\.


--
-- TOC entry 3037 (class 0 OID 51412)
-- Dependencies: 201
-- Data for Name: indicators; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.indicators (id, uid, name, short_name, code, definition, indicator_group_id, numerator_description, numerator_formula, denominator_description, denominator_formula, indicator_type, annualized, use_and_context, frequency, level, favorite, nids_versions, created_at, updated_at, created_by, updated_by) FROM stdin;
2	zl9l8qYZAiO	All DS-TB client lost to follow-up rate	All DS-TB LTF rate	TBCLTFR	TB clients who started drug-susceptible tuberculosis (DS-TB) treatment and\r\nwho subsequently became lost to follow-up as a proportion of all those in the\r\ntreatment outcome cohort	3	All DS-TB lost to follow-up	{All DS-TB client lost to follow-up}	All DS-TB in treatment outcome cohort	All DS-TB in treatment outcome cohort		false	Monitors trends in the effectiveness of the retention in care strategies, and\r\ntrends in lost to follow-up from TB treatment, as one of the factors suppressing the\r\nTB treatment success rate	Quarterly	outcome	false	\N	1617534591	1617534597	14	14
\.


--
-- TOC entry 3047 (class 0 OID 51466)
-- Dependencies: 211
-- Data for Name: validation_rule_operator; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.validation_rule_operator (id, name, description) FROM stdin;
2	compulsory_pair	
3	less_than_or_equal_to	
4	greater_than_or_equal_to	
5	equal_to	
\.


--
-- TOC entry 3045 (class 0 OID 51456)
-- Dependencies: 209
-- Data for Name: validation_rules; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.validation_rules (id, uid, name, description, left_side, right_side, type, created_at, updated_at, created_by, updated_by, operator) FROM stdin;
2	kUpdVY14HbJ	Antenatal 1st visit before 20 weeks PAIR Antenatal 1st visit 20 weeks or later	Antenatal 1st visit before 20 weeks is paired with Antenatal 1st visit 20 weeks\r\nor later	 {Antenatal 1st visit before 20 weeks}	{Antenatal 1st visit 20 weeks or later}		1617388056	1617530247	14	14	2
\.


--
-- TOC entry 3053 (class 0 OID 0)
-- Dependencies: 204
-- Name: data_element_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.data_element_group_id_seq', 5, true);


--
-- TOC entry 3054 (class 0 OID 0)
-- Dependencies: 206
-- Name: data_elements_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.data_elements_id_seq', 3, true);


--
-- TOC entry 3055 (class 0 OID 0)
-- Dependencies: 202
-- Name: indicator_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.indicator_group_id_seq', 3, true);


--
-- TOC entry 3056 (class 0 OID 0)
-- Dependencies: 203
-- Name: indicators_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.indicators_id_seq', 2, true);


--
-- TOC entry 3057 (class 0 OID 0)
-- Dependencies: 210
-- Name: validation_rule_operator_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.validation_rule_operator_id_seq', 5, true);


--
-- TOC entry 3058 (class 0 OID 0)
-- Dependencies: 208
-- Name: validation_rules_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.validation_rules_id_seq', 2, true);


--
-- TOC entry 2897 (class 2606 OID 51438)
-- Name: data_element_group data_element_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.data_element_group
    ADD CONSTRAINT data_element_group_pkey PRIMARY KEY (id);


--
-- TOC entry 2899 (class 2606 OID 51445)
-- Name: data_elements data_elements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.data_elements
    ADD CONSTRAINT data_elements_pkey PRIMARY KEY (id);


--
-- TOC entry 2893 (class 2606 OID 51411)
-- Name: indicator_group indicator_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.indicator_group
    ADD CONSTRAINT indicator_group_pkey PRIMARY KEY (id);


--
-- TOC entry 2895 (class 2606 OID 51419)
-- Name: indicators indicators_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.indicators
    ADD CONSTRAINT indicators_pkey PRIMARY KEY (id);


--
-- TOC entry 2903 (class 2606 OID 51473)
-- Name: validation_rule_operator validation_rule_operator_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.validation_rule_operator
    ADD CONSTRAINT validation_rule_operator_pkey PRIMARY KEY (id);


--
-- TOC entry 2901 (class 2606 OID 51463)
-- Name: validation_rules validation_rules_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.validation_rules
    ADD CONSTRAINT validation_rules_pkey PRIMARY KEY (id);


--
-- TOC entry 2905 (class 2606 OID 51446)
-- Name: data_elements data_element_group_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.data_elements
    ADD CONSTRAINT data_element_group_fkey FOREIGN KEY (id) REFERENCES public.data_element_group(id);


--
-- TOC entry 2904 (class 2606 OID 51424)
-- Name: indicators indicator_group_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.indicators
    ADD CONSTRAINT indicator_group_fkey FOREIGN KEY (indicator_group_id) REFERENCES public.indicator_group(id) NOT VALID;


-- Completed on 2021-04-06 12:19:26 CAT

--
-- PostgreSQL database dump complete
--

