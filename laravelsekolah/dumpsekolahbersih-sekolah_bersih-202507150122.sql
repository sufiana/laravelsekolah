PGDMP                         }            sekolah_bersih    15.13    15.13 P    l           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            m           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            n           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            o           1262    16405    sekolah_bersih    DATABASE     �   CREATE DATABASE sekolah_bersih WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE sekolah_bersih;
                postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                pg_database_owner    false            p           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                   pg_database_owner    false    4            �            1259    32799    evaluasi_kuesioner    TABLE     �  CREATE TABLE public.evaluasi_kuesioner (
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
 &   DROP TABLE public.evaluasi_kuesioner;
       public         heap    postgres    false    4            �            1259    32798    evaluasi_kuesioner_id_seq    SEQUENCE     �   CREATE SEQUENCE public.evaluasi_kuesioner_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.evaluasi_kuesioner_id_seq;
       public          postgres    false    230    4            q           0    0    evaluasi_kuesioner_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.evaluasi_kuesioner_id_seq OWNED BY public.evaluasi_kuesioner.id;
          public          postgres    false    229            �            1259    24624    hasil_kuesioner    TABLE     r  CREATE TABLE public.hasil_kuesioner (
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
 #   DROP TABLE public.hasil_kuesioner;
       public         heap    postgres    false    4            �            1259    24623    hasil_kuesioner_id_seq    SEQUENCE     �   CREATE SEQUENCE public.hasil_kuesioner_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.hasil_kuesioner_id_seq;
       public          postgres    false    4    220            r           0    0    hasil_kuesioner_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.hasil_kuesioner_id_seq OWNED BY public.hasil_kuesioner.id;
          public          postgres    false    219            �            1259    24679    kegiatan_siswa    TABLE     2  CREATE TABLE public.kegiatan_siswa (
    id integer NOT NULL,
    id_sekolah integer,
    id_siswa integer,
    jam_awal timestamp without time zone,
    jam_akhir timestamp without time zone,
    kegiatan character varying(100),
    lokasi character varying(50),
    user_created character varying(50)
);
 "   DROP TABLE public.kegiatan_siswa;
       public         heap    postgres    false    4            �            1259    24678    kegiatan_siswa_id_seq    SEQUENCE     �   CREATE SEQUENCE public.kegiatan_siswa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.kegiatan_siswa_id_seq;
       public          postgres    false    4    226            s           0    0    kegiatan_siswa_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.kegiatan_siswa_id_seq OWNED BY public.kegiatan_siswa.id;
          public          postgres    false    225            �            1259    16423    parameter_kebersihan    TABLE     S  CREATE TABLE public.parameter_kebersihan (
    id integer NOT NULL,
    id_ruang smallint NOT NULL,
    parameter character varying NOT NULL,
    deskripsi character varying,
    user_created character varying,
    time_created timestamp without time zone,
    user_update character varying,
    time_update timestamp without time zone
);
 (   DROP TABLE public.parameter_kebersihan;
       public         heap    postgres    false    4            �            1259    32830    parameter_kebersihan_1    TABLE     :  CREATE TABLE public.parameter_kebersihan_1 (
    id integer,
    id_ruang smallint,
    parameter character varying,
    deskripsi character varying,
    user_created character varying,
    time_created timestamp without time zone,
    user_update character varying,
    time_update timestamp without time zone
);
 *   DROP TABLE public.parameter_kebersihan_1;
       public         heap    postgres    false    4            �            1259    16422    parameter_kebersihan_id_seq    SEQUENCE     �   CREATE SEQUENCE public.parameter_kebersihan_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.parameter_kebersihan_id_seq;
       public          postgres    false    4    217            t           0    0    parameter_kebersihan_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.parameter_kebersihan_id_seq OWNED BY public.parameter_kebersihan.id;
          public          postgres    false    216            �            1259    32806    penilaian_kuesioner    TABLE     �   CREATE TABLE public.penilaian_kuesioner (
    id integer NOT NULL,
    id_ruang integer,
    batas_atas integer,
    batas_bawah integer,
    hasil character varying(50),
    score integer
);
 '   DROP TABLE public.penilaian_kuesioner;
       public         heap    postgres    false    4            �            1259    32805    penilaian_kuesioner_id_seq    SEQUENCE     �   CREATE SEQUENCE public.penilaian_kuesioner_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.penilaian_kuesioner_id_seq;
       public          postgres    false    232    4            u           0    0    penilaian_kuesioner_id_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.penilaian_kuesioner_id_seq OWNED BY public.penilaian_kuesioner.id;
          public          postgres    false    231            �            1259    24648    role    TABLE     �   CREATE TABLE public.role (
    id integer NOT NULL,
    name character varying,
    deskripsi character varying,
    butuh_sekolah boolean DEFAULT false
);
    DROP TABLE public.role;
       public         heap    postgres    false    4            �            1259    24647    role_id_seq    SEQUENCE     �   CREATE SEQUENCE public.role_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.role_id_seq;
       public          postgres    false    224    4            v           0    0    role_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.role_id_seq OWNED BY public.role.id;
          public          postgres    false    223            �            1259    16414    ruang_sekolah    TABLE     �   CREATE TABLE public.ruang_sekolah (
    id integer NOT NULL,
    nama character varying,
    deskripsi character varying,
    gambar character varying,
    singkatan character varying,
    url character varying,
    aktif boolean DEFAULT true
);
 !   DROP TABLE public.ruang_sekolah;
       public         heap    postgres    false    4            �            1259    32821    ruang_sekolah_1    TABLE     �   CREATE TABLE public.ruang_sekolah_1 (
    id integer NOT NULL,
    nama character varying,
    deskripsi character varying,
    gambar character varying,
    singkatan character varying,
    url character varying,
    aktif boolean DEFAULT true
);
 #   DROP TABLE public.ruang_sekolah_1;
       public         heap    postgres    false    4            �            1259    32820    ruang_sekolah_1_id_seq    SEQUENCE     �   CREATE SEQUENCE public.ruang_sekolah_1_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.ruang_sekolah_1_id_seq;
       public          postgres    false    234    4            w           0    0    ruang_sekolah_1_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.ruang_sekolah_1_id_seq OWNED BY public.ruang_sekolah_1.id;
          public          postgres    false    233            �            1259    16413    ruang_sekolah_id_seq    SEQUENCE     �   CREATE SEQUENCE public.ruang_sekolah_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.ruang_sekolah_id_seq;
       public          postgres    false    4    215            x           0    0    ruang_sekolah_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.ruang_sekolah_id_seq OWNED BY public.ruang_sekolah.id;
          public          postgres    false    214            �            1259    24597    sekolah    TABLE     �  CREATE TABLE public.sekolah (
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
    DROP TABLE public.sekolah;
       public         heap    postgres    false    4            �            1259    32790    session    TABLE     �   CREATE TABLE public.session (
    sid character varying NOT NULL,
    sess json NOT NULL,
    expire timestamp(6) without time zone NOT NULL
);
    DROP TABLE public.session;
       public         heap    postgres    false    4            �            1259    24685 	   tbot_user    TABLE     �   CREATE TABLE public.tbot_user (
    user_id text,
    user_name text,
    nop_id text,
    group_id text,
    role_id bigint,
    chat_id text,
    password character varying
);
    DROP TABLE public.tbot_user;
       public         heap    postgres    false    4            �            1259    24633    users    TABLE     �  CREATE TABLE public.users (
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
    DROP TABLE public.users;
       public         heap    postgres    false    4            �            1259    24632    users_id_seq    SEQUENCE     �   CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    4    222            y           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    221            �           2604    32802    evaluasi_kuesioner id    DEFAULT     ~   ALTER TABLE ONLY public.evaluasi_kuesioner ALTER COLUMN id SET DEFAULT nextval('public.evaluasi_kuesioner_id_seq'::regclass);
 D   ALTER TABLE public.evaluasi_kuesioner ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    229    230    230            �           2604    24627    hasil_kuesioner id    DEFAULT     x   ALTER TABLE ONLY public.hasil_kuesioner ALTER COLUMN id SET DEFAULT nextval('public.hasil_kuesioner_id_seq'::regclass);
 A   ALTER TABLE public.hasil_kuesioner ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    220    220            �           2604    24682    kegiatan_siswa id    DEFAULT     v   ALTER TABLE ONLY public.kegiatan_siswa ALTER COLUMN id SET DEFAULT nextval('public.kegiatan_siswa_id_seq'::regclass);
 @   ALTER TABLE public.kegiatan_siswa ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    225    226    226            �           2604    16426    parameter_kebersihan id    DEFAULT     �   ALTER TABLE ONLY public.parameter_kebersihan ALTER COLUMN id SET DEFAULT nextval('public.parameter_kebersihan_id_seq'::regclass);
 F   ALTER TABLE public.parameter_kebersihan ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    216    217    217            �           2604    32809    penilaian_kuesioner id    DEFAULT     �   ALTER TABLE ONLY public.penilaian_kuesioner ALTER COLUMN id SET DEFAULT nextval('public.penilaian_kuesioner_id_seq'::regclass);
 E   ALTER TABLE public.penilaian_kuesioner ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    232    231    232            �           2604    24651    role id    DEFAULT     b   ALTER TABLE ONLY public.role ALTER COLUMN id SET DEFAULT nextval('public.role_id_seq'::regclass);
 6   ALTER TABLE public.role ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    223    224    224            �           2604    16417    ruang_sekolah id    DEFAULT     t   ALTER TABLE ONLY public.ruang_sekolah ALTER COLUMN id SET DEFAULT nextval('public.ruang_sekolah_id_seq'::regclass);
 ?   ALTER TABLE public.ruang_sekolah ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    214    215    215            �           2604    32824    ruang_sekolah_1 id    DEFAULT     x   ALTER TABLE ONLY public.ruang_sekolah_1 ALTER COLUMN id SET DEFAULT nextval('public.ruang_sekolah_1_id_seq'::regclass);
 A   ALTER TABLE public.ruang_sekolah_1 ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    233    234    234            �           2604    24636    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    222    221    222            d          0    32799    evaluasi_kuesioner 
   TABLE DATA           �   COPY public.evaluasi_kuesioner (id, id_kuesioner, sekolah, periode_awal_kuesioner, periode_akhir_kuesioner, status_verifikasi_sekolah, status_evaluasi_pengawas, status_evaluasi_cabdis, id_ruang, score, hasil_score) FROM stdin;
    public          postgres    false    230   �i       Z          0    24624    hasil_kuesioner 
   TABLE DATA           �  COPY public.hasil_kuesioner (id, id_sekolah, id_user, id_parameter, id_ruang, jawaban, deskripsi_jawaban, tahun_ajaran, periode, time_created, user_created, time_update, user_updated, status_verifikasi, user_verifikasi, jabatan_verifikasi, tanggal_verifikasi, status_approval_disdik, jabatan_approval_disdik, user_approval_disdik, tanggal_approval_disdik, periode_awal_kuesioner, periode_akhir_kuesioner) FROM stdin;
    public          postgres    false    220   j       `          0    24679    kegiatan_siswa 
   TABLE DATA           w   COPY public.kegiatan_siswa (id, id_sekolah, id_siswa, jam_awal, jam_akhir, kegiatan, lokasi, user_created) FROM stdin;
    public          postgres    false    226   �j       W          0    16423    parameter_kebersihan 
   TABLE DATA           �   COPY public.parameter_kebersihan (id, id_ruang, parameter, deskripsi, user_created, time_created, user_update, time_update) FROM stdin;
    public          postgres    false    217   �j       i          0    32830    parameter_kebersihan_1 
   TABLE DATA           �   COPY public.parameter_kebersihan_1 (id, id_ruang, parameter, deskripsi, user_created, time_created, user_update, time_update) FROM stdin;
    public          postgres    false    235   �o       f          0    32806    penilaian_kuesioner 
   TABLE DATA           b   COPY public.penilaian_kuesioner (id, id_ruang, batas_atas, batas_bawah, hasil, score) FROM stdin;
    public          postgres    false    232   Su       ^          0    24648    role 
   TABLE DATA           B   COPY public.role (id, name, deskripsi, butuh_sekolah) FROM stdin;
    public          postgres    false    224   �u       U          0    16414    ruang_sekolah 
   TABLE DATA           [   COPY public.ruang_sekolah (id, nama, deskripsi, gambar, singkatan, url, aktif) FROM stdin;
    public          postgres    false    215   Zv       h          0    32821    ruang_sekolah_1 
   TABLE DATA           ]   COPY public.ruang_sekolah_1 (id, nama, deskripsi, gambar, singkatan, url, aktif) FROM stdin;
    public          postgres    false    234   �w       X          0    24597    sekolah 
   TABLE DATA           l  COPY public.sekolah (id, nama, npsn, bentuk_pendidikan_id, status_sekolah, alamat_jalan, rt, rw, dusun, desa_kelurahan, kecamatan, kabupaten_kota, provinsi, kode_wilayah, kode_pos, lintang, bujur, nomor_telepon, email, website, sk_penetapan, tanggal_sk_penetapan, jumlah_siswa_l, jumlah_siswa_p, tahun_ajaran_id, semester_id, create_date, last_update) FROM stdin;
    public          postgres    false    218   Yy       b          0    32790    session 
   TABLE DATA           4   COPY public.session (sid, sess, expire) FROM stdin;
    public          postgres    false    228   �y       a          0    24685 	   tbot_user 
   TABLE DATA           e   COPY public.tbot_user (user_id, user_name, nop_id, group_id, role_id, chat_id, password) FROM stdin;
    public          postgres    false    227   �y       \          0    24633    users 
   TABLE DATA             COPY public.users (id, username, email, password_hash, google_id, google_email, google_name, role, id_sekolah, is_active, is_verified, verification_token, verification_expires, refresh_token, refresh_token_expires, last_login, created_at, updated_at) FROM stdin;
    public          postgres    false    222   z       z           0    0    evaluasi_kuesioner_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.evaluasi_kuesioner_id_seq', 21, true);
          public          postgres    false    229            {           0    0    hasil_kuesioner_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.hasil_kuesioner_id_seq', 325, true);
          public          postgres    false    219            |           0    0    kegiatan_siswa_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.kegiatan_siswa_id_seq', 1, true);
          public          postgres    false    225            }           0    0    parameter_kebersihan_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.parameter_kebersihan_id_seq', 97, true);
          public          postgres    false    216            ~           0    0    penilaian_kuesioner_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.penilaian_kuesioner_id_seq', 1, true);
          public          postgres    false    231                       0    0    role_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('public.role_id_seq', 8, true);
          public          postgres    false    223            �           0    0    ruang_sekolah_1_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.ruang_sekolah_1_id_seq', 17, true);
          public          postgres    false    233            �           0    0    ruang_sekolah_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.ruang_sekolah_id_seq', 17, true);
          public          postgres    false    214            �           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 20, true);
          public          postgres    false    221            �           2606    32804 *   evaluasi_kuesioner evaluasi_kuesioner_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.evaluasi_kuesioner
    ADD CONSTRAINT evaluasi_kuesioner_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.evaluasi_kuesioner DROP CONSTRAINT evaluasi_kuesioner_pkey;
       public            postgres    false    230            �           2606    24631 $   hasil_kuesioner hasil_kuesioner_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.hasil_kuesioner
    ADD CONSTRAINT hasil_kuesioner_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.hasil_kuesioner DROP CONSTRAINT hasil_kuesioner_pkey;
       public            postgres    false    220            �           2606    24684 "   kegiatan_siswa kegiatan_siswa_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.kegiatan_siswa
    ADD CONSTRAINT kegiatan_siswa_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.kegiatan_siswa DROP CONSTRAINT kegiatan_siswa_pkey;
       public            postgres    false    226            �           2606    16430 .   parameter_kebersihan parameter_kebersihan_pkey 
   CONSTRAINT     l   ALTER TABLE ONLY public.parameter_kebersihan
    ADD CONSTRAINT parameter_kebersihan_pkey PRIMARY KEY (id);
 X   ALTER TABLE ONLY public.parameter_kebersihan DROP CONSTRAINT parameter_kebersihan_pkey;
       public            postgres    false    217            �           2606    32811 ,   penilaian_kuesioner penilaian_kuesioner_pkey 
   CONSTRAINT     j   ALTER TABLE ONLY public.penilaian_kuesioner
    ADD CONSTRAINT penilaian_kuesioner_pkey PRIMARY KEY (id);
 V   ALTER TABLE ONLY public.penilaian_kuesioner DROP CONSTRAINT penilaian_kuesioner_pkey;
       public            postgres    false    232            �           2606    24655    role role_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.role
    ADD CONSTRAINT role_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.role DROP CONSTRAINT role_pkey;
       public            postgres    false    224            �           2606    16421     ruang_sekolah ruang_sekolah_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.ruang_sekolah
    ADD CONSTRAINT ruang_sekolah_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.ruang_sekolah DROP CONSTRAINT ruang_sekolah_pkey;
       public            postgres    false    215            �           2606    32829 $   ruang_sekolah_1 ruang_sekolah_pkey_1 
   CONSTRAINT     b   ALTER TABLE ONLY public.ruang_sekolah_1
    ADD CONSTRAINT ruang_sekolah_pkey_1 PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.ruang_sekolah_1 DROP CONSTRAINT ruang_sekolah_pkey_1;
       public            postgres    false    234            �           2606    24658    sekolah sekolah_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.sekolah
    ADD CONSTRAINT sekolah_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.sekolah DROP CONSTRAINT sekolah_pkey;
       public            postgres    false    218            �           2606    32796    session session_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_pkey PRIMARY KEY (sid);
 >   ALTER TABLE ONLY public.session DROP CONSTRAINT session_pkey;
       public            postgres    false    228            �           2606    24646    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    222            �           1259    32797    IDX_session_expire    INDEX     J   CREATE INDEX "IDX_session_expire" ON public.session USING btree (expire);
 (   DROP INDEX public."IDX_session_expire";
       public            postgres    false    228            d   @   x�32�66��162 bC 6bc 6b�ZNCCN##S]3]cd�e��T�b���� b��      Z   �   x���;
�0 �Y>E/`����9DO��K K��%��KD�TZFBH �	 $P��Y}+�3��Iģ�c�����R��A������Q.�F��w��;`68��;�hp���Co��sOX>��<��s�      `   (   x�3�440�4�4202�5 "C+0��#�=... �c+      W   �  x��W�n�H<�_��.�D�!� H ;Y��{ɥ)������~�g(Q�PJ������U݉�(�F�@2|�������V��wq���&T��2D?��_����G����TR_�J`u/�n�E�hK0,H��(̥q
�g�;ڳ��P�;*	���м�%"�K;��c/�,Ec�jLc�S=u���E��B�����A�����΃յ�=����^PX�c�p�?�>�%Pc�\5�7��f�G0~�u	�X3�������EA=�vJ�qh$�თP�'�P��ː4uaߪVy�I���E)�l\ �[e0��*S��ӜVT���mX�����em���l��oU:�}�U�[�0Y���3P����vg*3�́]�4�ތE��V67BK6�=qS+ ea�*s��Ӊ����1�xl�ܙƎ�ic��M"��"y�<�*��A�!G�c���Ƈy�Hc ��>��4��c��i�8�W������³O9���4���;S���h�$d�5�t6��)q���Q�)M�ڟ1liᦳC���9m��W<��@����r�Zi�T�[T�LY�x�fIm�-�6\����JR�=��V��X��$ i�o�@�a�3"O��J[�j��x��q�Ta\��Q#*C�T�=���V�2v�{d-ʤ�� N	=P�w�1x��d��v���n�J��G��q���x�<���I)9�9J�6A<T����MY��4��K�x	ӱ/����B��_�z��˭�k��`�����ly�X�K��8��(	Ͽ\Vq��n`>�D<����?���N��(1��}�r0��Tt_���	qƠ�^[��B�q���)�5W� ��[@
�밫*�׍�&΁�-.�Z�5��a���ڝ�ʛe���o��d	�G�Bi�(ye.\��++�S�D����$��̨M���t9}��n	r䓣�I�kS:Β��;Y� ���Fj,$�����%&[�ž��j�E�]^��r{�o�*�*Xߏ���w�����g�9O���թ���%@�.�(i9y�8��إ�#�Ta��F޸gPW���q3���n?2.���t4n�����=�l�� >��ؒ��aO<�]m�.C���v�	�v_���p/(	+@18�az�oX���I�(���]Ѷ�U�yV�J� \��Y��L/�s���m"F�)Pmm��cZ��R=M��]M��]DW�������+W�      i   �  x��XMo�F=˿��*�<&(Z�N�6�K.Cq-��	.��}��Ҧ̕Kr��y;������_���Ԏ$�Q�Z}����U���#��+��*=(�bi�_
�/�%(�z�}ԵT'�"X]���[o�U�%��Rzi���������J�o�8�ϴD$@�Ս�w;%Kњ������+��z����>Ȓ*�=TT��pU�.��UpJ�c��0�<�>�_�(����Ԕ'���&��c�FOM�/�h��?`��(
Xۙ.rc� ��C�q���(�?�G�zo誮r�Ux�`~����T�	L��*� �s���x�hLX#i����%5^�^����!�3��*]u�;b���s8��s���2�A`���9�� Z�gq�a�A�	L/�/gr� ��|��n�N��ߞ`��_�����K�p��J?t��c���?�Fz�&�V�t���S�a��W��.J��i�a���O�C���$]{�D;JL
#ۣnw�I皇1���5Bg_���{C��(���N�0��ǎ��B�)�Uז�t���8B]q�=��F���0�Tg��g�5�s�r%���dˁ���T��*.C�N�F`?#.OT
!J.޵��s%���nF�3�g��3	�$�A7G���\I���%�"�.�$�2IF�'I���OOwx��q�k���(r�1?t��Ӆ��V�ﴍ(����{�0�k���/�	�+�ː��J�ӭ�7���g��A�(w�X�6/l����TXv>�t2�m���͛M�*r�+Ƒ�^g���"�h
*@lb\0Tf�v�<�+a�ܝ�("�l=5ė.���Ac�{݄��7��^�C����G�9��sT)��qΘ/vײ���u�k&���q,AɆA�T#C�ThYk��l���$>���V�ջ�6A�`�}�^�Q�de/�i�}h�s��d��MG��$b�iL�Yv�:f�)[�wѴ��L�gr�D�0��f����B�`�$mMh֣�v�}b�Q�#���:c�m7�����\�^l�%�3�c�9׺)4��v��eà��.���4��9`�3=;�%�I�D-)a���m�KL�39�J��+BTM�;4e��HGzs.�<�����]k��okD��!��s@�����"��b�cK��_<�Uty�ӄ�gg8Mvn�3]��ܐ<?��Ƹ�8Ù�����,�~)��,v��8��_^��u�8�x�RW���H��b�:�dR��# ��T�u�0x��l��t�o�V�SB�^�,�`t���d�r�e���`$�_����T��zB�i�튮��Aq��N�{��|�g_(���wz\�>����F��U���H�jh~�:�`�|j�8�T娬�"�򈑿(Y�g\,Y��%Kg�gJ���������2\      f   )   x�3�4�446�445�,N�KO,QHJ-*��������� �M�      ^   �   x�E���0�g�)� �aeb`A*bB�qJ�6�괼>Iӊ��uwk�<pմ���]���\�b�sF��M���:8��:L2j%�T��sM�b�N[mKr�� ��%Ʌ˦������#H�P��,Ju�ԑo����Y�����1y�ἁ94͞�W[��)�>�'c0L��\z���\*�~�Adc      U   T  x�]R�n�0}v�������L�	Ъ��^54J������M`���Ǘ���=��bQ�a�ͨآѶ��-�(Xl<6��즖=�K���Ğ���d�z����� ���J�ݺ�N����,*�9�N�+ߐ�����fmI��$�z�%�ء���4*Jr]���R�b�l��HVz��﹣!�k"�9�3u�� ����	R�	D��[�-���35	D��a��<�<��޾^;"�@�W��P�3�T?!vX얽]��8���r�i�C�R���Q�h�ui����۟���e�^ן�gG��sP{+v�܆E0sX����P����}�����b      h   �  x�}RMo�0=S�"�`���]�m�����Dl,H�T���?ْ]��]�H��/��N؝+ruB1�[b8����`����C�p�=�
�̓���[���B.�d�ö�-�����hI�"ٱ�`����Z��S�S6���:7U�C��>b� [�Lc|_R��v�8��TPw�!)
Z�`m���ӜΉ0wD}�5<c�k���9��G�psGԏ:��u�����V������آ����W[�G�t�� O��j�L�=L���L�O��0p*�S.a�����ҿ���-�W�÷�qvL�#嫚kx̗��{:�r�)�V��� [��b�)�4xy����Hl��֐��������仪�KR��'�D�k�>2���SԟoJ���      X   1   x�340�,N���I�P(I-�rc������MW�u�3��1z\\\ O�/�      b      x������ � �      a   D   x��qq1�w�Up�q�sww�4��5400227032730�4�4205575765������� ��_      \   �  x���Mo�0��ɯ��w�v&�OK�l%�I�K��R��f���o"��]6=�d˲_i�}����<N�M��d��<W�V�(yf���j�Y��� ��n�[�n6ٯ����2���N���O�N/�=?���j^^����PRk���_4;*��b�֫[���Ł;-���:�+ÉINZ�����`i̀+t���*��3O����M�ƺ���<o9��uON�t��Gi6^�f�0�>u��U?Wk��y��&���2
�T��pj�Pͳ�����;x��m�͞��=��~.��<[��p�oq��}�/���˳ pT����0���B���D~��/B�����u���N��ോ��'T���2�a apu�J��mۿ���     