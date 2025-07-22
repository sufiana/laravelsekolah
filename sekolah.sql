--
-- PostgreSQL database dump
--

-- Dumped from database version 15.13
-- Dumped by pg_dump version 15.13

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
-- Name: evaluasi_kuesioner; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evaluasi_kuesioner (
    id integer NOT NULL,
    id_kuesioner character varying(255),
    sekolah integer,
    periode_awal_kuesioner date,
    periode_akhir_kuesioner date,
    status_verifikasi_sekolah numeric(1,0),
    status_evaluasi_pengawas numeric(1,0),
    status_evaluasi_cabdis numeric(1,0),
    id_ruang smallint,
    score smallint,
    hasil_score character varying(100)
);


ALTER TABLE public.evaluasi_kuesioner OWNER TO postgres;

--
-- Name: evaluasi_kuesioner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.evaluasi_kuesioner_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.evaluasi_kuesioner_id_seq OWNER TO postgres;

--
-- Name: evaluasi_kuesioner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.evaluasi_kuesioner_id_seq OWNED BY public.evaluasi_kuesioner.id;


--
-- Name: hasil_kuesioner; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hasil_kuesioner (
    id integer NOT NULL,
    id_sekolah integer,
    id_user integer,
    id_parameter integer,
    id_ruang integer,
    jawaban integer,
    deskripsi_jawaban text,
    tahun_ajaran character varying(10),
    periode integer,
    time_created timestamp without time zone,
    user_created character varying,
    time_update timestamp without time zone,
    user_updated timestamp without time zone,
    status_verifikasi character varying(1),
    user_verifikasi character varying,
    jabatan_verifikasi character varying,
    tanggal_verifikasi timestamp without time zone,
    status_approval_disdik character varying(1),
    jabatan_approval_disdik character varying,
    user_approval_disdik character varying,
    tanggal_approval_disdik timestamp without time zone,
    periode_awal_kuesioner date,
    periode_akhir_kuesioner date
);


ALTER TABLE public.hasil_kuesioner OWNER TO postgres;

--
-- Name: hasil_kuesioner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.hasil_kuesioner_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.hasil_kuesioner_id_seq OWNER TO postgres;

--
-- Name: hasil_kuesioner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.hasil_kuesioner_id_seq OWNED BY public.hasil_kuesioner.id;


--
-- Name: kegiatan_siswa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kegiatan_siswa (
    id integer NOT NULL,
    id_sekolah integer,
    id_siswa integer,
    jam_awal timestamp without time zone,
    jam_akhir timestamp without time zone,
    kegiatan character varying(100),
    lokasi character varying(50),
    user_created character varying(50)
);


ALTER TABLE public.kegiatan_siswa OWNER TO postgres;

--
-- Name: kegiatan_siswa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kegiatan_siswa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kegiatan_siswa_id_seq OWNER TO postgres;

--
-- Name: kegiatan_siswa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kegiatan_siswa_id_seq OWNED BY public.kegiatan_siswa.id;


--
-- Name: parameter_kebersihan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parameter_kebersihan (
    id integer NOT NULL,
    id_ruang smallint NOT NULL,
    parameter character varying NOT NULL,
    deskripsi character varying,
    user_created character varying,
    time_created timestamp without time zone,
    user_update character varying,
    time_update timestamp without time zone
);


ALTER TABLE public.parameter_kebersihan OWNER TO postgres;

--
-- Name: parameter_kebersihan_1; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parameter_kebersihan_1 (
    id integer,
    id_ruang smallint,
    parameter character varying,
    deskripsi character varying,
    user_created character varying,
    time_created timestamp without time zone,
    user_update character varying,
    time_update timestamp without time zone
);


ALTER TABLE public.parameter_kebersihan_1 OWNER TO postgres;

--
-- Name: parameter_kebersihan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.parameter_kebersihan_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parameter_kebersihan_id_seq OWNER TO postgres;

--
-- Name: parameter_kebersihan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.parameter_kebersihan_id_seq OWNED BY public.parameter_kebersihan.id;


--
-- Name: penilaian_kuesioner; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.penilaian_kuesioner (
    id integer NOT NULL,
    id_ruang integer,
    batas_atas integer,
    batas_bawah integer,
    hasil character varying(50),
    score integer
);


ALTER TABLE public.penilaian_kuesioner OWNER TO postgres;

--
-- Name: penilaian_kuesioner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.penilaian_kuesioner_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.penilaian_kuesioner_id_seq OWNER TO postgres;

--
-- Name: penilaian_kuesioner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.penilaian_kuesioner_id_seq OWNED BY public.penilaian_kuesioner.id;


--
-- Name: role; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role (
    id integer NOT NULL,
    name character varying,
    deskripsi character varying,
    butuh_sekolah boolean DEFAULT false
);


ALTER TABLE public.role OWNER TO postgres;

--
-- Name: role_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.role_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.role_id_seq OWNER TO postgres;

--
-- Name: role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.role_id_seq OWNED BY public.role.id;


--
-- Name: ruang_sekolah; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ruang_sekolah (
    id integer NOT NULL,
    nama character varying,
    deskripsi character varying,
    gambar character varying,
    singkatan character varying,
    url character varying,
    aktif boolean DEFAULT true
);


ALTER TABLE public.ruang_sekolah OWNER TO postgres;

--
-- Name: ruang_sekolah_1; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ruang_sekolah_1 (
    id integer NOT NULL,
    nama character varying,
    deskripsi character varying,
    gambar character varying,
    singkatan character varying,
    url character varying,
    aktif boolean DEFAULT true
);


ALTER TABLE public.ruang_sekolah_1 OWNER TO postgres;

--
-- Name: ruang_sekolah_1_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ruang_sekolah_1_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ruang_sekolah_1_id_seq OWNER TO postgres;

--
-- Name: ruang_sekolah_1_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ruang_sekolah_1_id_seq OWNED BY public.ruang_sekolah_1.id;


--
-- Name: ruang_sekolah_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ruang_sekolah_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ruang_sekolah_id_seq OWNER TO postgres;

--
-- Name: ruang_sekolah_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ruang_sekolah_id_seq OWNED BY public.ruang_sekolah.id;


--
-- Name: sekolah; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sekolah (
    id integer NOT NULL,
    nama character varying(100),
    npsn character varying(8),
    bentuk_pendidikan_id integer,
    status_sekolah integer,
    alamat_jalan text,
    rt character varying(5),
    rw character varying(5),
    dusun character varying(50),
    desa_kelurahan character varying(50),
    kecamatan character varying(50),
    kabupaten_kota character varying(50),
    provinsi character varying(50),
    kode_wilayah character varying(8),
    kode_pos character varying(5),
    lintang numeric(10,7),
    bujur numeric(10,7),
    nomor_telepon character varying(20),
    email character varying(100),
    website character varying(100),
    sk_penetapan character varying(50),
    tanggal_sk_penetapan date,
    jumlah_siswa_l integer,
    jumlah_siswa_p integer,
    tahun_ajaran_id character(36),
    semester_id character(8),
    create_date timestamp without time zone,
    last_update timestamp without time zone
);


ALTER TABLE public.sekolah OWNER TO postgres;

--
-- Name: session; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.session (
    sid character varying NOT NULL,
    sess json NOT NULL,
    expire timestamp(6) without time zone NOT NULL
);


ALTER TABLE public.session OWNER TO postgres;

--
-- Name: tbot_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbot_user (
    user_id text,
    user_name text,
    nop_id text,
    group_id text,
    role_id bigint,
    chat_id text,
    password character varying
);


ALTER TABLE public.tbot_user OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username character varying(50) NOT NULL,
    email character varying NOT NULL,
    password_hash character varying(255),
    google_id character varying,
    google_email character varying,
    google_name character varying,
    role integer NOT NULL,
    id_sekolah integer DEFAULT 0,
    is_active boolean DEFAULT true,
    is_verified boolean DEFAULT false,
    verification_token character varying,
    verification_expires timestamp without time zone,
    refresh_token character varying(255),
    refresh_token_expires timestamp without time zone,
    last_login timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT login_method_check CHECK (((password_hash IS NOT NULL) OR (google_id IS NOT NULL)))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: evaluasi_kuesioner id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluasi_kuesioner ALTER COLUMN id SET DEFAULT nextval('public.evaluasi_kuesioner_id_seq'::regclass);


--
-- Name: hasil_kuesioner id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hasil_kuesioner ALTER COLUMN id SET DEFAULT nextval('public.hasil_kuesioner_id_seq'::regclass);


--
-- Name: kegiatan_siswa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kegiatan_siswa ALTER COLUMN id SET DEFAULT nextval('public.kegiatan_siswa_id_seq'::regclass);


--
-- Name: parameter_kebersihan id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parameter_kebersihan ALTER COLUMN id SET DEFAULT nextval('public.parameter_kebersihan_id_seq'::regclass);


--
-- Name: penilaian_kuesioner id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.penilaian_kuesioner ALTER COLUMN id SET DEFAULT nextval('public.penilaian_kuesioner_id_seq'::regclass);


--
-- Name: role id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role ALTER COLUMN id SET DEFAULT nextval('public.role_id_seq'::regclass);


--
-- Name: ruang_sekolah id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ruang_sekolah ALTER COLUMN id SET DEFAULT nextval('public.ruang_sekolah_id_seq'::regclass);


--
-- Name: ruang_sekolah_1 id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ruang_sekolah_1 ALTER COLUMN id SET DEFAULT nextval('public.ruang_sekolah_1_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: evaluasi_kuesioner; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evaluasi_kuesioner (id, id_kuesioner, sekolah, periode_awal_kuesioner, periode_akhir_kuesioner, status_verifikasi_sekolah, status_evaluasi_pengawas, status_evaluasi_cabdis, id_ruang, score, hasil_score) FROM stdin;
21	{319,320,321,322,323,324,325}	101	2025-06-03	2025-06-03	0	0	0	1	21	100%
\.


--
-- Data for Name: hasil_kuesioner; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hasil_kuesioner (id, id_sekolah, id_user, id_parameter, id_ruang, jawaban, deskripsi_jawaban, tahun_ajaran, periode, time_created, user_created, time_update, user_updated, status_verifikasi, user_verifikasi, jabatan_verifikasi, tanggal_verifikasi, status_approval_disdik, jabatan_approval_disdik, user_approval_disdik, tanggal_approval_disdik, periode_awal_kuesioner, periode_akhir_kuesioner) FROM stdin;
319	101	5	1	1	3	\N	2025-2026	\N	2025-07-13 12:38:24.385	sufiana.az15	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2025-06-03	2025-06-03
320	101	5	2	1	3	\N	2025-2026	\N	2025-07-13 12:38:24.398	sufiana.az15	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2025-06-03	2025-06-03
322	101	5	4	1	3	\N	2025-2026	\N	2025-07-13 12:38:24.399	sufiana.az15	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2025-06-03	2025-06-03
324	101	5	6	1	3	\N	2025-2026	\N	2025-07-13 12:38:24.399	sufiana.az15	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2025-06-03	2025-06-03
325	101	5	7	1	3	\N	2025-2026	\N	2025-07-13 12:38:24.399	sufiana.az15	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2025-06-03	2025-06-03
321	101	5	3	1	2	\N	2025-2026	\N	2025-07-13 12:38:24.399	sufiana.az15	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2025-06-03	2025-06-03
323	101	5	5	1	1	\N	2025-2026	\N	2025-07-13 12:38:24.399	sufiana.az15	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2025-06-03	2025-06-03
\.


--
-- Data for Name: kegiatan_siswa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kegiatan_siswa (id, id_sekolah, id_siswa, jam_awal, jam_akhir, kegiatan, lokasi, user_created) FROM stdin;
1	101	1	2025-05-01 00:00:00	\N	\N	\N	\N
\.


--
-- Data for Name: parameter_kebersihan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.parameter_kebersihan (id, id_ruang, parameter, deskripsi, user_created, time_created, user_update, time_update) FROM stdin;
1	1	Lantai Kelas	\N	\N	\N	\N	\N
2	1	Meja dan kursi tertata dan bersih	\N	\N	\N	\N	\N
3	1	Papan tulis bersih	\N	\N	\N	\N	\N
4	1	Jendela / kaca bebas debu	\N	\N	\N	\N	\N
5	1	Sampah terbuang pada tempatnya	\N	\N	\N	\N	\N
6	1	Foto Presiden dan Gubernur tertata rapi	\N	\N	\N	\N	\N
7	1	Tidak ada kabel berserakan	\N	\N	\N	\N	\N
8	2	Meja dan kursi tertata rapi	\N	\N	\N	\N	\N
9	2	Area makan tidak ada sisa makanan	\N	\N	\N	\N	\N
10	2	Lantai bersih dan kering	\N	\N	\N	\N	\N
11	2	Tempat sampah tidak penuh	\N	\N	\N	\N	\N
12	2	Tidak ada barang berserakan / tidak terpakai	\N	\N	\N	\N	\N
13	2	Ruang bebas dari asap rokok	\N	\N	\N	\N	\N
14	3	Meja dan kursi tertata rapi	\N	\N	\N	\N	\N
15	3	Kabel tidak berserakan	\N	\N	\N	\N	\N
16	3	Dokumen tertata dalam lemari atau laci	\N	\N	\N	\N	\N
17	3	Karpet / tirai bersih dan kering	\N	\N	\N	\N	\N
18	3	Tempat sampah kosong	\N	\N	\N	\N	\N
47	8	Karpet / Sajadah bersih dan tergulung	\N	\N	\N	\N	\N
48	8	Tempat wudhu tidak licin dan kering	\N	\N	\N	\N	\N
49	8	Rak alat ibadah tertata rapi	\N	\N	\N	\N	\N
50	8	Bebas debu dan bau	\N	\N	\N	\N	\N
51	8	Tidak digunakan untuk penyimpanan barang	\N	\N	\N	\N	\N
52	9	Tempat tidur rapi, alas kasur bersih	\N	\N	\N	\N	\N
53	9	Lemari P3K tertata dan tidak kosong	\N	\N	\N	\N	\N
54	9	Lantai kering, tidak lembab	\N	\N	\N	\N	\N
55	9	Tidak digunakan sebagai gudang	\N	\N	\N	\N	\N
56	9	Ventilasi cukup dan ruangan tidak pengap	\N	\N	\N	\N	\N
71	10	Drainase atau parit tidak tersumbat	\N	\N	\N	\N	\N
72	10	Tidak ada bekas makanan / kemasan di taman	\N	\N	\N	\N	\N
73	10	Tidak ada batang pohon tumbang / dahan liar	\N	\N	\N	\N	\N
74	10	Area bebas dari puntung rokok dan abu bakaran	\N	\N	\N	\N	\N
83	11	Lantai bersih dari oli atau lumpur	\N	\N	\N	\N	\N
84	11	Jalur masuk dan keluar tidak terhalang	\N	\N	\N	\N	\N
85	11	Tidak ada sampah di sekitar area parkir	\N	\N	\N	\N	\N
86	11	Drainase area parkir tidak tersumbat	\N	\N	\N	\N	\N
87	11	Tidak ada kendaraan parkir sembarangan	\N	\N	\N	\N	\N
88	12	Meja dan kursi piket bersih dan rapi	\N	\N	\N	\N	\N
29	4	Kloset (jongkok/duduk)	\N	\N	\N	\N	\N
30	4	Lantai Toilet	\N	\N	\N	\N	\N
31	4	Westafel dan cermin	\N	\N	\N	\N	\N
32	4	Sabun cuci tangan tersedia	\N	\N	\N	\N	\N
33	4	Tempat Sampah tidak penuh	\N	\N	\N	\N	\N
34	4	Tidak bau / Ventilasi berfungsi baik	\N	\N	\N	\N	\N
35	4	Pintu dapat ditutup dan di kunci	\N	\N	\N	\N	\N
36	4	Plafon / asbes dalam kondisi baik	\N	\N	\N	\N	\N
37	5	Rak buku / peralatan bebas debu	\N	\N	\N	\N	\N
38	5	Meja baca / meja praktikum bersih	\N	\N	\N	\N	\N
39	5	Tidak ada sampah atau kertas berserakan	\N	\N	\N	\N	\N
40	5	Alat eksperimen / buku tersimpan rapi	\N	\N	\N	\N	\N
41	5	Area bebas makanan dan minuman	\N	\N	\N	\N	\N
57	6	Lantai gudang bersih dan tidak lembab	\N	\N	\N	\N	\N
58	6	Rak tertata dan mudah di akses	\N	\N	\N	\N	\N
59	6	Barang tidak menumpuk di lantai	\N	\N	\N	\N	\N
60	6	Jalur akses keluar tidak terhalang	\N	\N	\N	\N	\N
61	6	Tidak ada kabel / alat rusak berserakan	\N	\N	\N	\N	\N
62	7	Makanan disajikan tertutup	\N	\N	\N	\N	\N
63	7	Meja makan dan rak makanan bersih	\N	\N	\N	\N	\N
64	7	Alat makan dicuci bersih	\N	\N	\N	\N	\N
65	7	Lantai tidak licin atau berminyak	\N	\N	\N	\N	\N
66	7	Tempat sampah tidak penuh dan tertutup	\N	\N	\N	\N	\N
67	10	Daun dan sampah disapu dari jalan setapak	\N	\N	\N	\N	\N
68	10	Pot bunga tertata dan tidak pecah	\N	\N	\N	\N	\N
69	10	Rumput liar tidak tumbuh tinggi	\N	\N	\N	\N	\N
70	10	Tanaman hijau disiram dan tidak layu	\N	\N	\N	\N	\N
89	12	Jadwal piket dan logbook terpasang dan terbaca	\N	\N	\N	\N	\N
90	12	Tidak ada sampah atau dokumen berserakan	\N	\N	\N	\N	\N
91	12	Alat komunikasi / administrasi tertata	\N	\N	\N	\N	\N
92	12	Tidak digunakan sebagai gudang barang	\N	\N	\N	\N	\N
\.


--
-- Data for Name: parameter_kebersihan_1; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.parameter_kebersihan_1 (id, id_ruang, parameter, deskripsi, user_created, time_created, user_update, time_update) FROM stdin;
1	1	Lantai Kelas	\N	\N	\N	\N	\N
2	1	Meja dan kursi tertata dan bersih	\N	\N	\N	\N	\N
3	1	Papan tulis bersih	\N	\N	\N	\N	\N
4	1	Jendela / kaca bebas debu	\N	\N	\N	\N	\N
5	1	Sampah terbuang pada tempatnya	\N	\N	\N	\N	\N
6	1	Foto Presiden dan Gubernur tertata rapi	\N	\N	\N	\N	\N
7	1	Tidak ada kabel berserakan	\N	\N	\N	\N	\N
8	2	Meja dan kursi tertata rapi	\N	\N	\N	\N	\N
9	2	Area makan tidak ada sisa makanan	\N	\N	\N	\N	\N
10	2	Lantai bersih dan kering	\N	\N	\N	\N	\N
11	2	Tempat sampah tidak penuh	\N	\N	\N	\N	\N
12	2	Tidak ada barang berserakan / tidak terpakai	\N	\N	\N	\N	\N
13	2	Ruang bebas dari asap rokok	\N	\N	\N	\N	\N
14	3	Meja dan kursi tertata rapi	\N	\N	\N	\N	\N
15	3	Kabel tidak berserakan	\N	\N	\N	\N	\N
16	3	Dokumen tertata dalam lemari atau laci	\N	\N	\N	\N	\N
17	3	Karpet / tirai bersih dan kering	\N	\N	\N	\N	\N
18	3	Tempat sampah kosong	\N	\N	\N	\N	\N
19	4	Meja dan kursi tertata rapi	\N	\N	\N	\N	\N
20	4	Kabel tidak berserakan	\N	\N	\N	\N	\N
21	4	Dokumen tertata dalam lemari atau laci	\N	\N	\N	\N	\N
22	4	Karpet / tirai bersih dan kering	\N	\N	\N	\N	\N
23	4	Tempat sampah kosong	\N	\N	\N	\N	\N
24	5	Meja dan kursi tertata rapi	\N	\N	\N	\N	\N
25	5	Kabel tidak berserakan	\N	\N	\N	\N	\N
26	5	Dokumen tertata dalam lemari atau laci	\N	\N	\N	\N	\N
27	5	Karpet / tirai bersih dan kering	\N	\N	\N	\N	\N
28	5	Tempat sampah kosong	\N	\N	\N	\N	\N
29	6	Kloset (jongkok/duduk)	\N	\N	\N	\N	\N
30	6	Lantai Toilet	\N	\N	\N	\N	\N
31	6	Westafel dan cermin	\N	\N	\N	\N	\N
32	6	Sabun cuci tangan tersedia	\N	\N	\N	\N	\N
33	6	Tempat Sampah tidak penuh	\N	\N	\N	\N	\N
34	6	Tidak bau / Ventilasi berfungsi baik	\N	\N	\N	\N	\N
35	6	Pintu dapat ditutup dan di kunci	\N	\N	\N	\N	\N
36	6	Plafon / asbes dalam kondisi baik	\N	\N	\N	\N	\N
37	7	Rak buku / peralatan bebas debu	\N	\N	\N	\N	\N
38	7	Meja baca / meja praktikum bersih	\N	\N	\N	\N	\N
39	7	Tidak ada sampah atau kertas berserakan	\N	\N	\N	\N	\N
40	7	Alat eksperimen / buku tersimpan rapi	\N	\N	\N	\N	\N
41	7	Area bebas makanan dan minuman	\N	\N	\N	\N	\N
42	8	Rak buku / peralatan bebas debu	\N	\N	\N	\N	\N
43	8	Meja baca / meja praktikum bersih	\N	\N	\N	\N	\N
44	8	Tidak ada sampah atau kertas berserakan	\N	\N	\N	\N	\N
45	8	Alat eksperimen / buku tersimpan rapi	\N	\N	\N	\N	\N
46	8	Area bebas makanan dan minuman	\N	\N	\N	\N	\N
47	9	Karpet / Sajadah bersih dan tergulung	\N	\N	\N	\N	\N
48	9	Tempat wudhu tidak licin dan kering	\N	\N	\N	\N	\N
49	9	Rak alat ibadah tertata rapi	\N	\N	\N	\N	\N
50	9	Bebas debu dan bau	\N	\N	\N	\N	\N
51	9	Tidak digunakan untuk penyimpanan barang	\N	\N	\N	\N	\N
52	10	Tempat tidur rapi, alas kasur bersih	\N	\N	\N	\N	\N
53	10	Lemari P3K tertata dan tidak kosong	\N	\N	\N	\N	\N
54	10	Lantai kering, tidak lembab	\N	\N	\N	\N	\N
55	10	Tidak digunakan sebagai gudang	\N	\N	\N	\N	\N
56	10	Ventilasi cukup dan ruangan tidak pengap	\N	\N	\N	\N	\N
57	11	Lantai gudang bersih dan tidak lembab	\N	\N	\N	\N	\N
58	11	Rak tertata dan mudah di akses	\N	\N	\N	\N	\N
59	11	Barang tidak menumpuk di lantai	\N	\N	\N	\N	\N
60	11	Jalur akses keluar tidak terhalang	\N	\N	\N	\N	\N
61	11	Tidak ada kabel / alat rusak berserakan	\N	\N	\N	\N	\N
62	12	Makanan disajikan tertutup	\N	\N	\N	\N	\N
63	12	Meja makan dan rak makanan bersih	\N	\N	\N	\N	\N
64	12	Alat makan dicuci bersih	\N	\N	\N	\N	\N
65	12	Lantai tidak licin atau berminyak	\N	\N	\N	\N	\N
66	12	Tempat sampah tidak penuh dan tertutup	\N	\N	\N	\N	\N
67	13	Daun dan sampah disapu dari jalan setapak	\N	\N	\N	\N	\N
68	13	Pot bunga tertata dan tidak pecah	\N	\N	\N	\N	\N
69	13	Rumput liar tidak tumbuh tinggi	\N	\N	\N	\N	\N
70	13	Tanaman hijau disiram dan tidak layu	\N	\N	\N	\N	\N
71	13	Drainase atau parit tidak tersumbat	\N	\N	\N	\N	\N
72	13	Tidak ada bekas makanan / kemasan di taman	\N	\N	\N	\N	\N
73	13	Tidak ada batang pohon tumbang / dahan liar	\N	\N	\N	\N	\N
74	13	Area bebas dari puntung rokok dan abu bakaran	\N	\N	\N	\N	\N
75	14	Daun dan sampah disapu dari jalan setapak	\N	\N	\N	\N	\N
76	14	Pot bunga tertata dan tidak pecah	\N	\N	\N	\N	\N
77	14	Rumput liar tidak tumbuh tinggi	\N	\N	\N	\N	\N
78	14	Tanaman hijau disiram dan tidak layu	\N	\N	\N	\N	\N
79	14	Drainase atau parit tidak tersumbat	\N	\N	\N	\N	\N
80	14	Tidak ada bekas makanan / kemasan di taman	\N	\N	\N	\N	\N
81	14	Tidak ada batang pohon tumbang / dahan liar	\N	\N	\N	\N	\N
82	14	Area bebas dari puntung rokok dan abu bakaran	\N	\N	\N	\N	\N
83	15	Lantai bersih dari oli atau lumpur	\N	\N	\N	\N	\N
84	15	Jalur masuk dan keluar tidak terhalang	\N	\N	\N	\N	\N
85	15	Tidak ada sampah di sekitar area parkir	\N	\N	\N	\N	\N
86	15	Drainase area parkir tidak tersumbat	\N	\N	\N	\N	\N
87	15	Tidak ada kendaraan parkir sembarangan	\N	\N	\N	\N	\N
88	16	Meja dan kursi piket bersih dan rapi	\N	\N	\N	\N	\N
89	16	Jadwal piket dan logbook terpasang dan terbaca	\N	\N	\N	\N	\N
90	16	Tidak ada sampah atau dokumen berserakan	\N	\N	\N	\N	\N
91	16	Alat komunikasi / administrasi tertata	\N	\N	\N	\N	\N
92	16	Tidak digunakan sebagai gudang barang	\N	\N	\N	\N	\N
93	17	Meja dan kursi piket bersih dan rapi	\N	\N	\N	\N	\N
94	17	Jadwal piket dan logbook terpasang dan terbaca	\N	\N	\N	\N	\N
95	17	Tidak ada sampah atau dokumen berserakan	\N	\N	\N	\N	\N
96	17	Alat komunikasi / administrasi tertata	\N	\N	\N	\N	\N
97	17	Tidak digunakan sebagai gudang barang	\N	\N	\N	\N	\N
\.


--
-- Data for Name: penilaian_kuesioner; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.penilaian_kuesioner (id, id_ruang, batas_atas, batas_bawah, hasil, score) FROM stdin;
1	5	130	150	sangat bersih	8
\.


--
-- Data for Name: role; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role (id, name, deskripsi, butuh_sekolah) FROM stdin;
1	developer	Pengembang sistem	f
4	cabang_dinas	Admin cabang dinas	f
5	kepala_dinas	Kepala dinas pendidikan	f
6	pengawas_sekolah	Pengawas sekolah	f
7	superadmin	Super administrator sistem	f
8	verifikator	Tim Verifikasi	f
2	sekolah	Admin sekolah	t
3	tata_usaha	Staff tata usaha	t
0	Guest	-	f
\.


--
-- Data for Name: ruang_sekolah; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ruang_sekolah (id, nama, deskripsi, gambar, singkatan, url, aktif) FROM stdin;
3	Ruang Kepala Sekolah, Wakil dan Tata Usaha		DoorClosedLocked	Ruang Kepsek	ruangkepsek	t
8	Ruang Ibadah		MoonStar	Ruang Ibadah	ruangibadah	t
9	Ruang UKS		Hospital	Ruang UKS	ruanguks	t
4	Toilet		Toilet	Toilet	toilet	t
5	Laboratorium, Perpustakaan dan Ruang Praktek		Microscope	Laboratorium	laboratorium	t
6	Ruang Gudang Sekolah		Warehouse	Gudang	gudang	t
7	Kantin		Coffee	Kantin	kantin	t
10	Taman dan Halaman Sekolah		Trees	Taman	taman	t
11	Parkir		SquareParking	Parkir	parkir	t
12	Ruang Sekuriti dan Piket Guru		ShieldPlus	Ruang Sekuriti	ruangsekuriti	t
2	Ruang Guru		DoorOpen	Ruang Guru	ruangguru	t
1	Ruang Kelas		GraduationCap	Ruang Kelas	ruangkelas	t
\.


--
-- Data for Name: ruang_sekolah_1; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ruang_sekolah_1 (id, nama, deskripsi, gambar, singkatan, url, aktif) FROM stdin;
1	Ruang Kelas		GraduationCap	Ruang Kelas	ruangkelas	t
2	Ruang Guru		DoorOpen	Ruang Guru	ruangguru	t
3	Ruang Kepala Sekolah		DoorClosedLocked	Ruang Kepsek	ruangkepsek	t
4	Ruang Wakil Kepala Sekolah		DoorClosed	Ruang Wakepsek	ruangwakepsek	t
5	Ruang Tata Usaha		Store	Ruang TU	ruangtu	t
6	Toilet		Toilet	Toilet	toilet	t
7	Perpustakaan		LibraryBig	Perpustakaan	perpustakaan	t
8	Laboratorium		Microscope	Laboratorium	laboratorium	t
9	Ruang Ibadah		MoonStar	Ruang Ibadah	ruangibadah	t
10	Ruang UKS		Hospital	Ruang UKS	ruanguks	t
11	Ruang Gudang Sekolah		Warehouse	Gudang	gudang	t
12	Kantin		Coffee	Kantin	kantin	t
13	Taman		Trees	Taman	taman	t
14	Halaman		TreeDeciduous	Halaman	halaman	t
15	Parkir		SquareParking	Parkir	parkir	t
16	Ruang Sekuriti		ShieldPlus	Ruang Sekuriti	ruangsekuriti	t
17	Ruang Piket Guru		IdCardLanyard	Ruang Piket	ruangpiket	t
\.


--
-- Data for Name: sekolah; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sekolah (id, nama, npsn, bentuk_pendidikan_id, status_sekolah, alamat_jalan, rt, rw, dusun, desa_kelurahan, kecamatan, kabupaten_kota, provinsi, kode_wilayah, kode_pos, lintang, bujur, nomor_telepon, email, website, sk_penetapan, tanggal_sk_penetapan, jumlah_siswa_l, jumlah_siswa_p, tahun_ajaran_id, semester_id, create_date, last_update) FROM stdin;
101	sekolah tes	01	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
102	sekolah tes SMAN1	01	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: session; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.session (sid, sess, expire) FROM stdin;
\.


--
-- Data for Name: tbot_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbot_user (user_id, user_name, nop_id, group_id, role_id, chat_id, password) FROM stdin;
TLCTD1	WAHYU ERLANGGA	6	-1002270627600	5	2055757351	\N
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, username, email, password_hash, google_id, google_email, google_name, role, id_sekolah, is_active, is_verified, verification_token, verification_expires, refresh_token, refresh_token_expires, last_login, created_at, updated_at) FROM stdin;
8	sufiana	sufiana.piliang@gmail.com	$2b$10$kJ0ucpDKUo9LXHnsyQZVGeacYbEiMSRWkD2izEJufMPkQE0gqYB/u	101082606763849988834	sufiana.piliang@gmail.com	sufiana piliang	1	0	t	f	\N	\N	\N	\N	2025-06-30 15:28:26.426933	2025-06-18 10:54:59.02817	2025-06-18 10:54:59.02817
5	sufiana.az15	sufiana.az15@gmail.com	$2b$10$Vqz6uCFxNNnf8U9LqIpMMeO4SmJ4W8WWdcaksUO/JbOYf6L6IUGX6	103543869039652377846	sufiana.az15@gmail.com	Sufiana Az	2	101	t	f	\N	\N	\N	\N	2025-07-15 01:39:22.140399	2025-06-18 10:51:19.560793	2025-06-18 10:51:19.560793
6	ana	ana@gmail.com	$2b$10$Vqz6uCFxNNnf8U9LqIpMMeO4SmJ4W8WWdcaksUO/JbOYf6L6IUGX6	\N	ana@gmail.com	Ana	2	102	t	f	\N	\N	\N	\N	2025-07-10 16:37:18.699303	2025-06-18 10:51:19.56	2025-06-18 10:51:19.56
9	sufiana	sufiana@gmail.com	$2b$10$kPh.xMnBoYsbh2PIx3PVkuY4Xvewq2sd9XAZHrkzwfz1d6fP02rXK	\N	\N	\N	2	101	t	f	\N	\N	\N	\N	\N	2025-06-18 13:00:50.921124	2025-06-18 13:00:50.921124
\.


--
-- Name: evaluasi_kuesioner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.evaluasi_kuesioner_id_seq', 21, true);


--
-- Name: hasil_kuesioner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hasil_kuesioner_id_seq', 325, true);


--
-- Name: kegiatan_siswa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kegiatan_siswa_id_seq', 1, true);


--
-- Name: parameter_kebersihan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.parameter_kebersihan_id_seq', 97, true);


--
-- Name: penilaian_kuesioner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.penilaian_kuesioner_id_seq', 1, true);


--
-- Name: role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.role_id_seq', 8, true);


--
-- Name: ruang_sekolah_1_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ruang_sekolah_1_id_seq', 17, true);


--
-- Name: ruang_sekolah_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ruang_sekolah_id_seq', 17, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 20, true);


--
-- Name: evaluasi_kuesioner evaluasi_kuesioner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluasi_kuesioner
    ADD CONSTRAINT evaluasi_kuesioner_pkey PRIMARY KEY (id);


--
-- Name: hasil_kuesioner hasil_kuesioner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hasil_kuesioner
    ADD CONSTRAINT hasil_kuesioner_pkey PRIMARY KEY (id);


--
-- Name: kegiatan_siswa kegiatan_siswa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kegiatan_siswa
    ADD CONSTRAINT kegiatan_siswa_pkey PRIMARY KEY (id);


--
-- Name: parameter_kebersihan parameter_kebersihan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parameter_kebersihan
    ADD CONSTRAINT parameter_kebersihan_pkey PRIMARY KEY (id);


--
-- Name: penilaian_kuesioner penilaian_kuesioner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.penilaian_kuesioner
    ADD CONSTRAINT penilaian_kuesioner_pkey PRIMARY KEY (id);


--
-- Name: role role_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role
    ADD CONSTRAINT role_pkey PRIMARY KEY (id);


--
-- Name: ruang_sekolah ruang_sekolah_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ruang_sekolah
    ADD CONSTRAINT ruang_sekolah_pkey PRIMARY KEY (id);


--
-- Name: ruang_sekolah_1 ruang_sekolah_pkey_1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ruang_sekolah_1
    ADD CONSTRAINT ruang_sekolah_pkey_1 PRIMARY KEY (id);


--
-- Name: sekolah sekolah_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sekolah
    ADD CONSTRAINT sekolah_pkey PRIMARY KEY (id);


--
-- Name: session session_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_pkey PRIMARY KEY (sid);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: IDX_session_expire; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "IDX_session_expire" ON public.session USING btree (expire);


--
-- PostgreSQL database dump complete
--

