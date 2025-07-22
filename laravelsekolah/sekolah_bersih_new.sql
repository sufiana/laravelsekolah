/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : PostgreSQL
 Source Server Version : 110000
 Source Host           : localhost:5432
 Source Catalog        : sekolah_bersih
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 110000
 File Encoding         : 65001

 Date: 22/07/2025 07:41:29
*/


-- ----------------------------
-- Sequence structure for evaluasi_kuesioner_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."evaluasi_kuesioner_id_seq";
CREATE SEQUENCE "public"."evaluasi_kuesioner_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for hasil_kuesioner_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."hasil_kuesioner_id_seq";
CREATE SEQUENCE "public"."hasil_kuesioner_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for kegiatan_siswa_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."kegiatan_siswa_id_seq";
CREATE SEQUENCE "public"."kegiatan_siswa_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for parameter_kebersihan_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."parameter_kebersihan_id_seq";
CREATE SEQUENCE "public"."parameter_kebersihan_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for penilaian_kuesioner_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."penilaian_kuesioner_id_seq";
CREATE SEQUENCE "public"."penilaian_kuesioner_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for role_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."role_id_seq";
CREATE SEQUENCE "public"."role_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for ruang_sekolah_1_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."ruang_sekolah_1_id_seq";
CREATE SEQUENCE "public"."ruang_sekolah_1_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for ruang_sekolah_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."ruang_sekolah_id_seq";
CREATE SEQUENCE "public"."ruang_sekolah_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."users_id_seq";
CREATE SEQUENCE "public"."users_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Table structure for evaluasi_kuesioner
-- ----------------------------
DROP TABLE IF EXISTS "public"."evaluasi_kuesioner";
CREATE TABLE "public"."evaluasi_kuesioner" (
  "id" int4 NOT NULL DEFAULT nextval('evaluasi_kuesioner_id_seq'::regclass),
  "id_kuesioner" varchar(255) COLLATE "pg_catalog"."default",
  "sekolah" int4,
  "periode_awal_kuesioner" date,
  "periode_akhir_kuesioner" date,
  "status_verifikasi_sekolah" numeric(1,0),
  "status_evaluasi_pengawas" numeric(1,0),
  "status_evaluasi_cabdis" numeric(1,0),
  "id_ruang" int2,
  "score" int2,
  "hasil_score" varchar(100) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of evaluasi_kuesioner
-- ----------------------------
INSERT INTO "public"."evaluasi_kuesioner" VALUES (21, '{319,320,321,322,323,324,325}', 101, '2025-06-03', '2025-06-03', 0, 0, 0, 1, 21, '100%');

-- ----------------------------
-- Table structure for hasil_kuesioner
-- ----------------------------
DROP TABLE IF EXISTS "public"."hasil_kuesioner";
CREATE TABLE "public"."hasil_kuesioner" (
  "id" int4 NOT NULL DEFAULT nextval('hasil_kuesioner_id_seq'::regclass),
  "id_sekolah" int4,
  "id_user" int4,
  "id_parameter" int4,
  "id_ruang" int4,
  "jawaban" int4,
  "deskripsi_jawaban" text COLLATE "pg_catalog"."default",
  "tahun_ajaran" varchar(10) COLLATE "pg_catalog"."default",
  "periode" int4,
  "time_created" timestamp(6),
  "user_created" varchar COLLATE "pg_catalog"."default",
  "time_update" timestamp(6),
  "user_updated" timestamp(6),
  "status_verifikasi" varchar(1) COLLATE "pg_catalog"."default",
  "user_verifikasi" varchar COLLATE "pg_catalog"."default",
  "jabatan_verifikasi" varchar COLLATE "pg_catalog"."default",
  "tanggal_verifikasi" timestamp(6),
  "status_approval_disdik" varchar(1) COLLATE "pg_catalog"."default",
  "jabatan_approval_disdik" varchar COLLATE "pg_catalog"."default",
  "user_approval_disdik" varchar COLLATE "pg_catalog"."default",
  "tanggal_approval_disdik" timestamp(6),
  "periode_awal_kuesioner" date,
  "periode_akhir_kuesioner" date
)
;

-- ----------------------------
-- Records of hasil_kuesioner
-- ----------------------------
INSERT INTO "public"."hasil_kuesioner" VALUES (319, 101, 5, 1, 1, 3, NULL, '2025-2026', NULL, '2025-07-13 12:38:24.385', 'sufiana.az15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-03', '2025-06-03');
INSERT INTO "public"."hasil_kuesioner" VALUES (320, 101, 5, 2, 1, 3, NULL, '2025-2026', NULL, '2025-07-13 12:38:24.398', 'sufiana.az15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-03', '2025-06-03');
INSERT INTO "public"."hasil_kuesioner" VALUES (322, 101, 5, 4, 1, 3, NULL, '2025-2026', NULL, '2025-07-13 12:38:24.399', 'sufiana.az15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-03', '2025-06-03');
INSERT INTO "public"."hasil_kuesioner" VALUES (324, 101, 5, 6, 1, 3, NULL, '2025-2026', NULL, '2025-07-13 12:38:24.399', 'sufiana.az15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-03', '2025-06-03');
INSERT INTO "public"."hasil_kuesioner" VALUES (325, 101, 5, 7, 1, 3, NULL, '2025-2026', NULL, '2025-07-13 12:38:24.399', 'sufiana.az15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-03', '2025-06-03');
INSERT INTO "public"."hasil_kuesioner" VALUES (321, 101, 5, 3, 1, 2, NULL, '2025-2026', NULL, '2025-07-13 12:38:24.399', 'sufiana.az15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-03', '2025-06-03');
INSERT INTO "public"."hasil_kuesioner" VALUES (323, 101, 5, 5, 1, 1, NULL, '2025-2026', NULL, '2025-07-13 12:38:24.399', 'sufiana.az15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-03', '2025-06-03');

-- ----------------------------
-- Table structure for kegiatan_siswa
-- ----------------------------
DROP TABLE IF EXISTS "public"."kegiatan_siswa";
CREATE TABLE "public"."kegiatan_siswa" (
  "id" int4 NOT NULL DEFAULT nextval('kegiatan_siswa_id_seq'::regclass),
  "id_sekolah" int4,
  "id_siswa" int4,
  "jam_awal" timestamp(6),
  "jam_akhir" timestamp(6),
  "kegiatan" varchar(100) COLLATE "pg_catalog"."default",
  "lokasi" varchar(50) COLLATE "pg_catalog"."default",
  "user_created" varchar(50) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of kegiatan_siswa
-- ----------------------------
INSERT INTO "public"."kegiatan_siswa" VALUES (1, 101, 1, '2025-05-01 00:00:00', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for parameter_kebersihan
-- ----------------------------
DROP TABLE IF EXISTS "public"."parameter_kebersihan";
CREATE TABLE "public"."parameter_kebersihan" (
  "id" int4 NOT NULL DEFAULT nextval('parameter_kebersihan_id_seq'::regclass),
  "id_ruang" int2 NOT NULL,
  "parameter" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "deskripsi" varchar COLLATE "pg_catalog"."default",
  "user_created" varchar COLLATE "pg_catalog"."default",
  "time_created" timestamp(6),
  "user_update" varchar COLLATE "pg_catalog"."default",
  "time_update" timestamp(6)
)
;

-- ----------------------------
-- Records of parameter_kebersihan
-- ----------------------------
INSERT INTO "public"."parameter_kebersihan" VALUES (1, 1, 'Lantai Kelas', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (2, 1, 'Meja dan kursi tertata dan bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (3, 1, 'Papan tulis bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (4, 1, 'Jendela / kaca bebas debu', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (5, 1, 'Sampah terbuang pada tempatnya', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (6, 1, 'Foto Presiden dan Gubernur tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (7, 1, 'Tidak ada kabel berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (8, 2, 'Meja dan kursi tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (9, 2, 'Area makan tidak ada sisa makanan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (10, 2, 'Lantai bersih dan kering', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (11, 2, 'Tempat sampah tidak penuh', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (12, 2, 'Tidak ada barang berserakan / tidak terpakai', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (13, 2, 'Ruang bebas dari asap rokok', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (14, 3, 'Meja dan kursi tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (15, 3, 'Kabel tidak berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (16, 3, 'Dokumen tertata dalam lemari atau laci', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (17, 3, 'Karpet / tirai bersih dan kering', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (18, 3, 'Tempat sampah kosong', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (47, 8, 'Karpet / Sajadah bersih dan tergulung', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (48, 8, 'Tempat wudhu tidak licin dan kering', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (49, 8, 'Rak alat ibadah tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (50, 8, 'Bebas debu dan bau', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (51, 8, 'Tidak digunakan untuk penyimpanan barang', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (52, 9, 'Tempat tidur rapi, alas kasur bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (53, 9, 'Lemari P3K tertata dan tidak kosong', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (54, 9, 'Lantai kering, tidak lembab', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (55, 9, 'Tidak digunakan sebagai gudang', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (56, 9, 'Ventilasi cukup dan ruangan tidak pengap', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (71, 10, 'Drainase atau parit tidak tersumbat', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (72, 10, 'Tidak ada bekas makanan / kemasan di taman', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (73, 10, 'Tidak ada batang pohon tumbang / dahan liar', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (74, 10, 'Area bebas dari puntung rokok dan abu bakaran', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (83, 11, 'Lantai bersih dari oli atau lumpur', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (84, 11, 'Jalur masuk dan keluar tidak terhalang', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (85, 11, 'Tidak ada sampah di sekitar area parkir', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (86, 11, 'Drainase area parkir tidak tersumbat', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (87, 11, 'Tidak ada kendaraan parkir sembarangan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (88, 12, 'Meja dan kursi piket bersih dan rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (29, 4, 'Kloset (jongkok/duduk)', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (30, 4, 'Lantai Toilet', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (31, 4, 'Westafel dan cermin', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (32, 4, 'Sabun cuci tangan tersedia', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (33, 4, 'Tempat Sampah tidak penuh', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (34, 4, 'Tidak bau / Ventilasi berfungsi baik', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (35, 4, 'Pintu dapat ditutup dan di kunci', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (36, 4, 'Plafon / asbes dalam kondisi baik', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (37, 5, 'Rak buku / peralatan bebas debu', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (38, 5, 'Meja baca / meja praktikum bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (39, 5, 'Tidak ada sampah atau kertas berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (40, 5, 'Alat eksperimen / buku tersimpan rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (41, 5, 'Area bebas makanan dan minuman', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (57, 6, 'Lantai gudang bersih dan tidak lembab', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (58, 6, 'Rak tertata dan mudah di akses', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (59, 6, 'Barang tidak menumpuk di lantai', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (60, 6, 'Jalur akses keluar tidak terhalang', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (61, 6, 'Tidak ada kabel / alat rusak berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (62, 7, 'Makanan disajikan tertutup', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (63, 7, 'Meja makan dan rak makanan bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (64, 7, 'Alat makan dicuci bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (65, 7, 'Lantai tidak licin atau berminyak', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (66, 7, 'Tempat sampah tidak penuh dan tertutup', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (67, 10, 'Daun dan sampah disapu dari jalan setapak', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (68, 10, 'Pot bunga tertata dan tidak pecah', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (69, 10, 'Rumput liar tidak tumbuh tinggi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (70, 10, 'Tanaman hijau disiram dan tidak layu', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (89, 12, 'Jadwal piket dan logbook terpasang dan terbaca', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (90, 12, 'Tidak ada sampah atau dokumen berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (91, 12, 'Alat komunikasi / administrasi tertata', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan" VALUES (92, 12, 'Tidak digunakan sebagai gudang barang', NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for parameter_kebersihan_1
-- ----------------------------
DROP TABLE IF EXISTS "public"."parameter_kebersihan_1";
CREATE TABLE "public"."parameter_kebersihan_1" (
  "id" int4,
  "id_ruang" int2,
  "parameter" varchar COLLATE "pg_catalog"."default",
  "deskripsi" varchar COLLATE "pg_catalog"."default",
  "user_created" varchar COLLATE "pg_catalog"."default",
  "time_created" timestamp(6),
  "user_update" varchar COLLATE "pg_catalog"."default",
  "time_update" timestamp(6)
)
;

-- ----------------------------
-- Records of parameter_kebersihan_1
-- ----------------------------
INSERT INTO "public"."parameter_kebersihan_1" VALUES (1, 1, 'Lantai Kelas', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (2, 1, 'Meja dan kursi tertata dan bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (3, 1, 'Papan tulis bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (4, 1, 'Jendela / kaca bebas debu', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (5, 1, 'Sampah terbuang pada tempatnya', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (6, 1, 'Foto Presiden dan Gubernur tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (7, 1, 'Tidak ada kabel berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (8, 2, 'Meja dan kursi tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (9, 2, 'Area makan tidak ada sisa makanan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (10, 2, 'Lantai bersih dan kering', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (11, 2, 'Tempat sampah tidak penuh', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (12, 2, 'Tidak ada barang berserakan / tidak terpakai', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (13, 2, 'Ruang bebas dari asap rokok', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (14, 3, 'Meja dan kursi tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (15, 3, 'Kabel tidak berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (16, 3, 'Dokumen tertata dalam lemari atau laci', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (17, 3, 'Karpet / tirai bersih dan kering', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (18, 3, 'Tempat sampah kosong', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (19, 4, 'Meja dan kursi tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (20, 4, 'Kabel tidak berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (21, 4, 'Dokumen tertata dalam lemari atau laci', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (22, 4, 'Karpet / tirai bersih dan kering', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (23, 4, 'Tempat sampah kosong', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (24, 5, 'Meja dan kursi tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (25, 5, 'Kabel tidak berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (26, 5, 'Dokumen tertata dalam lemari atau laci', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (27, 5, 'Karpet / tirai bersih dan kering', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (28, 5, 'Tempat sampah kosong', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (29, 6, 'Kloset (jongkok/duduk)', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (30, 6, 'Lantai Toilet', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (31, 6, 'Westafel dan cermin', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (32, 6, 'Sabun cuci tangan tersedia', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (33, 6, 'Tempat Sampah tidak penuh', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (34, 6, 'Tidak bau / Ventilasi berfungsi baik', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (35, 6, 'Pintu dapat ditutup dan di kunci', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (36, 6, 'Plafon / asbes dalam kondisi baik', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (37, 7, 'Rak buku / peralatan bebas debu', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (38, 7, 'Meja baca / meja praktikum bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (39, 7, 'Tidak ada sampah atau kertas berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (40, 7, 'Alat eksperimen / buku tersimpan rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (41, 7, 'Area bebas makanan dan minuman', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (42, 8, 'Rak buku / peralatan bebas debu', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (43, 8, 'Meja baca / meja praktikum bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (44, 8, 'Tidak ada sampah atau kertas berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (45, 8, 'Alat eksperimen / buku tersimpan rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (46, 8, 'Area bebas makanan dan minuman', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (47, 9, 'Karpet / Sajadah bersih dan tergulung', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (48, 9, 'Tempat wudhu tidak licin dan kering', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (49, 9, 'Rak alat ibadah tertata rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (50, 9, 'Bebas debu dan bau', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (51, 9, 'Tidak digunakan untuk penyimpanan barang', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (52, 10, 'Tempat tidur rapi, alas kasur bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (53, 10, 'Lemari P3K tertata dan tidak kosong', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (54, 10, 'Lantai kering, tidak lembab', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (55, 10, 'Tidak digunakan sebagai gudang', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (56, 10, 'Ventilasi cukup dan ruangan tidak pengap', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (57, 11, 'Lantai gudang bersih dan tidak lembab', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (58, 11, 'Rak tertata dan mudah di akses', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (59, 11, 'Barang tidak menumpuk di lantai', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (60, 11, 'Jalur akses keluar tidak terhalang', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (61, 11, 'Tidak ada kabel / alat rusak berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (62, 12, 'Makanan disajikan tertutup', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (63, 12, 'Meja makan dan rak makanan bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (64, 12, 'Alat makan dicuci bersih', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (65, 12, 'Lantai tidak licin atau berminyak', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (66, 12, 'Tempat sampah tidak penuh dan tertutup', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (67, 13, 'Daun dan sampah disapu dari jalan setapak', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (68, 13, 'Pot bunga tertata dan tidak pecah', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (69, 13, 'Rumput liar tidak tumbuh tinggi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (70, 13, 'Tanaman hijau disiram dan tidak layu', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (71, 13, 'Drainase atau parit tidak tersumbat', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (72, 13, 'Tidak ada bekas makanan / kemasan di taman', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (73, 13, 'Tidak ada batang pohon tumbang / dahan liar', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (74, 13, 'Area bebas dari puntung rokok dan abu bakaran', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (75, 14, 'Daun dan sampah disapu dari jalan setapak', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (76, 14, 'Pot bunga tertata dan tidak pecah', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (77, 14, 'Rumput liar tidak tumbuh tinggi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (78, 14, 'Tanaman hijau disiram dan tidak layu', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (79, 14, 'Drainase atau parit tidak tersumbat', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (80, 14, 'Tidak ada bekas makanan / kemasan di taman', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (81, 14, 'Tidak ada batang pohon tumbang / dahan liar', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (82, 14, 'Area bebas dari puntung rokok dan abu bakaran', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (83, 15, 'Lantai bersih dari oli atau lumpur', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (84, 15, 'Jalur masuk dan keluar tidak terhalang', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (85, 15, 'Tidak ada sampah di sekitar area parkir', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (86, 15, 'Drainase area parkir tidak tersumbat', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (87, 15, 'Tidak ada kendaraan parkir sembarangan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (88, 16, 'Meja dan kursi piket bersih dan rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (89, 16, 'Jadwal piket dan logbook terpasang dan terbaca', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (90, 16, 'Tidak ada sampah atau dokumen berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (91, 16, 'Alat komunikasi / administrasi tertata', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (92, 16, 'Tidak digunakan sebagai gudang barang', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (93, 17, 'Meja dan kursi piket bersih dan rapi', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (94, 17, 'Jadwal piket dan logbook terpasang dan terbaca', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (95, 17, 'Tidak ada sampah atau dokumen berserakan', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (96, 17, 'Alat komunikasi / administrasi tertata', NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."parameter_kebersihan_1" VALUES (97, 17, 'Tidak digunakan sebagai gudang barang', NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for penilaian_kuesioner
-- ----------------------------
DROP TABLE IF EXISTS "public"."penilaian_kuesioner";
CREATE TABLE "public"."penilaian_kuesioner" (
  "id" int4 NOT NULL DEFAULT nextval('penilaian_kuesioner_id_seq'::regclass),
  "id_ruang" int4,
  "batas_atas" int4,
  "batas_bawah" int4,
  "hasil" varchar(50) COLLATE "pg_catalog"."default",
  "score" int4
)
;

-- ----------------------------
-- Records of penilaian_kuesioner
-- ----------------------------
INSERT INTO "public"."penilaian_kuesioner" VALUES (1, 5, 130, 150, 'sangat bersih', 8);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS "public"."role";
CREATE TABLE "public"."role" (
  "id" int4 NOT NULL DEFAULT nextval('role_id_seq'::regclass),
  "name" varchar COLLATE "pg_catalog"."default",
  "deskripsi" varchar COLLATE "pg_catalog"."default",
  "butuh_sekolah" bool DEFAULT false
)
;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO "public"."role" VALUES (1, 'developer', 'Pengembang sistem', 'f');
INSERT INTO "public"."role" VALUES (4, 'cabang_dinas', 'Admin cabang dinas', 'f');
INSERT INTO "public"."role" VALUES (5, 'kepala_dinas', 'Kepala dinas pendidikan', 'f');
INSERT INTO "public"."role" VALUES (6, 'pengawas_sekolah', 'Pengawas sekolah', 'f');
INSERT INTO "public"."role" VALUES (7, 'superadmin', 'Super administrator sistem', 'f');
INSERT INTO "public"."role" VALUES (8, 'verifikator', 'Tim Verifikasi', 'f');
INSERT INTO "public"."role" VALUES (2, 'sekolah', 'Admin sekolah', 't');
INSERT INTO "public"."role" VALUES (3, 'tata_usaha', 'Staff tata usaha', 't');
INSERT INTO "public"."role" VALUES (0, 'Guest', '-', 'f');

-- ----------------------------
-- Table structure for ruang_sekolah
-- ----------------------------
DROP TABLE IF EXISTS "public"."ruang_sekolah";
CREATE TABLE "public"."ruang_sekolah" (
  "id" int4 NOT NULL DEFAULT nextval('ruang_sekolah_id_seq'::regclass),
  "nama" varchar COLLATE "pg_catalog"."default",
  "deskripsi" varchar COLLATE "pg_catalog"."default",
  "gambar" varchar COLLATE "pg_catalog"."default",
  "singkatan" varchar COLLATE "pg_catalog"."default",
  "url" varchar COLLATE "pg_catalog"."default",
  "aktif" bool DEFAULT true
)
;

-- ----------------------------
-- Records of ruang_sekolah
-- ----------------------------
INSERT INTO "public"."ruang_sekolah" VALUES (3, 'Ruang Kepala Sekolah, Wakil dan Tata Usaha', '', 'DoorClosedLocked', 'Ruang Kepsek', 'ruangkepsek', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (8, 'Ruang Ibadah', '', 'MoonStar', 'Ruang Ibadah', 'ruangibadah', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (9, 'Ruang UKS', '', 'Hospital', 'Ruang UKS', 'ruanguks', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (4, 'Toilet', '', 'Toilet', 'Toilet', 'toilet', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (5, 'Laboratorium, Perpustakaan dan Ruang Praktek', '', 'Microscope', 'Laboratorium', 'laboratorium', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (6, 'Ruang Gudang Sekolah', '', 'Warehouse', 'Gudang', 'gudang', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (7, 'Kantin', '', 'Coffee', 'Kantin', 'kantin', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (10, 'Taman dan Halaman Sekolah', '', 'Trees', 'Taman', 'taman', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (11, 'Parkir', '', 'SquareParking', 'Parkir', 'parkir', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (12, 'Ruang Sekuriti dan Piket Guru', '', 'ShieldPlus', 'Ruang Sekuriti', 'ruangsekuriti', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (2, 'Ruang Guru', '', 'DoorOpen', 'Ruang Guru', 'ruangguru', 't');
INSERT INTO "public"."ruang_sekolah" VALUES (1, 'Ruang Kelas', '', 'GraduationCap', 'Ruang Kelas', 'ruangkelas', 't');

-- ----------------------------
-- Table structure for ruang_sekolah_1
-- ----------------------------
DROP TABLE IF EXISTS "public"."ruang_sekolah_1";
CREATE TABLE "public"."ruang_sekolah_1" (
  "id" int4 NOT NULL DEFAULT nextval('ruang_sekolah_1_id_seq'::regclass),
  "nama" varchar COLLATE "pg_catalog"."default",
  "deskripsi" varchar COLLATE "pg_catalog"."default",
  "gambar" varchar COLLATE "pg_catalog"."default",
  "singkatan" varchar COLLATE "pg_catalog"."default",
  "url" varchar COLLATE "pg_catalog"."default",
  "aktif" bool DEFAULT true
)
;

-- ----------------------------
-- Records of ruang_sekolah_1
-- ----------------------------
INSERT INTO "public"."ruang_sekolah_1" VALUES (1, 'Ruang Kelas', '', 'GraduationCap', 'Ruang Kelas', 'ruangkelas', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (2, 'Ruang Guru', '', 'DoorOpen', 'Ruang Guru', 'ruangguru', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (3, 'Ruang Kepala Sekolah', '', 'DoorClosedLocked', 'Ruang Kepsek', 'ruangkepsek', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (4, 'Ruang Wakil Kepala Sekolah', '', 'DoorClosed', 'Ruang Wakepsek', 'ruangwakepsek', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (5, 'Ruang Tata Usaha', '', 'Store', 'Ruang TU', 'ruangtu', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (6, 'Toilet', '', 'Toilet', 'Toilet', 'toilet', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (7, 'Perpustakaan', '', 'LibraryBig', 'Perpustakaan', 'perpustakaan', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (8, 'Laboratorium', '', 'Microscope', 'Laboratorium', 'laboratorium', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (9, 'Ruang Ibadah', '', 'MoonStar', 'Ruang Ibadah', 'ruangibadah', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (10, 'Ruang UKS', '', 'Hospital', 'Ruang UKS', 'ruanguks', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (11, 'Ruang Gudang Sekolah', '', 'Warehouse', 'Gudang', 'gudang', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (12, 'Kantin', '', 'Coffee', 'Kantin', 'kantin', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (13, 'Taman', '', 'Trees', 'Taman', 'taman', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (14, 'Halaman', '', 'TreeDeciduous', 'Halaman', 'halaman', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (15, 'Parkir', '', 'SquareParking', 'Parkir', 'parkir', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (16, 'Ruang Sekuriti', '', 'ShieldPlus', 'Ruang Sekuriti', 'ruangsekuriti', 't');
INSERT INTO "public"."ruang_sekolah_1" VALUES (17, 'Ruang Piket Guru', '', 'IdCardLanyard', 'Ruang Piket', 'ruangpiket', 't');

-- ----------------------------
-- Table structure for sekolah
-- ----------------------------
DROP TABLE IF EXISTS "public"."sekolah";
CREATE TABLE "public"."sekolah" (
  "id" int4 NOT NULL,
  "nama" varchar(100) COLLATE "pg_catalog"."default",
  "npsn" varchar(8) COLLATE "pg_catalog"."default",
  "bentuk_pendidikan_id" int4,
  "status_sekolah" int4,
  "alamat_jalan" text COLLATE "pg_catalog"."default",
  "rt" varchar(5) COLLATE "pg_catalog"."default",
  "rw" varchar(5) COLLATE "pg_catalog"."default",
  "dusun" varchar(50) COLLATE "pg_catalog"."default",
  "desa_kelurahan" varchar(50) COLLATE "pg_catalog"."default",
  "kecamatan" varchar(50) COLLATE "pg_catalog"."default",
  "kabupaten_kota" varchar(50) COLLATE "pg_catalog"."default",
  "provinsi" varchar(50) COLLATE "pg_catalog"."default",
  "kode_wilayah" varchar(8) COLLATE "pg_catalog"."default",
  "kode_pos" varchar(5) COLLATE "pg_catalog"."default",
  "lintang" numeric(10,7),
  "bujur" numeric(10,7),
  "nomor_telepon" varchar(20) COLLATE "pg_catalog"."default",
  "email" varchar(100) COLLATE "pg_catalog"."default",
  "website" varchar(100) COLLATE "pg_catalog"."default",
  "sk_penetapan" varchar(50) COLLATE "pg_catalog"."default",
  "tanggal_sk_penetapan" date,
  "jumlah_siswa_l" int4,
  "jumlah_siswa_p" int4,
  "tahun_ajaran_id" char(36) COLLATE "pg_catalog"."default",
  "semester_id" char(8) COLLATE "pg_catalog"."default",
  "create_date" timestamp(6),
  "last_update" timestamp(6)
)
;

-- ----------------------------
-- Records of sekolah
-- ----------------------------
INSERT INTO "public"."sekolah" VALUES (101, 'sekolah tes', '01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "public"."sekolah" VALUES (102, 'sekolah tes SMAN1', '01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for session
-- ----------------------------
DROP TABLE IF EXISTS "public"."session";
CREATE TABLE "public"."session" (
  "sid" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "sess" json NOT NULL,
  "expire" timestamp(6) NOT NULL
)
;

-- ----------------------------
-- Records of session
-- ----------------------------

-- ----------------------------
-- Table structure for tbot_user
-- ----------------------------
DROP TABLE IF EXISTS "public"."tbot_user";
CREATE TABLE "public"."tbot_user" (
  "user_id" text COLLATE "pg_catalog"."default",
  "user_name" text COLLATE "pg_catalog"."default",
  "nop_id" text COLLATE "pg_catalog"."default",
  "group_id" text COLLATE "pg_catalog"."default",
  "role_id" int8,
  "chat_id" text COLLATE "pg_catalog"."default",
  "password" varchar COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of tbot_user
-- ----------------------------
INSERT INTO "public"."tbot_user" VALUES ('TLCTD1', 'WAHYU ERLANGGA', '6', '-1002270627600', 5, '2055757351', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "id" int4 NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  "username" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "password_hash" varchar(255) COLLATE "pg_catalog"."default",
  "google_id" varchar COLLATE "pg_catalog"."default",
  "google_email" varchar COLLATE "pg_catalog"."default",
  "google_name" varchar COLLATE "pg_catalog"."default",
  "role" int4 NOT NULL,
  "id_sekolah" int4 DEFAULT 0,
  "is_active" bool DEFAULT true,
  "is_verified" bool DEFAULT false,
  "verification_token" varchar COLLATE "pg_catalog"."default",
  "verification_expires" timestamp(6),
  "refresh_token" varchar(255) COLLATE "pg_catalog"."default",
  "refresh_token_expires" timestamp(6),
  "last_login" timestamp(6),
  "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP
)
;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "public"."users" VALUES (8, 'sufiana', 'sufiana.piliang@gmail.com', '$2b$10$kJ0ucpDKUo9LXHnsyQZVGeacYbEiMSRWkD2izEJufMPkQE0gqYB/u', '101082606763849988834', 'sufiana.piliang@gmail.com', 'sufiana piliang', 1, 0, 't', 'f', NULL, NULL, NULL, NULL, '2025-06-30 15:28:26.426933', '2025-06-18 10:54:59.02817', '2025-06-18 10:54:59.02817');
INSERT INTO "public"."users" VALUES (5, 'sufiana.az15', 'sufiana.az15@gmail.com', '$2b$10$Vqz6uCFxNNnf8U9LqIpMMeO4SmJ4W8WWdcaksUO/JbOYf6L6IUGX6', '103543869039652377846', 'sufiana.az15@gmail.com', 'Sufiana Az', 2, 101, 't', 'f', NULL, NULL, NULL, NULL, '2025-07-15 01:39:22.140399', '2025-06-18 10:51:19.560793', '2025-06-18 10:51:19.560793');
INSERT INTO "public"."users" VALUES (6, 'ana', 'ana@gmail.com', '$2b$10$Vqz6uCFxNNnf8U9LqIpMMeO4SmJ4W8WWdcaksUO/JbOYf6L6IUGX6', NULL, 'ana@gmail.com', 'Ana', 2, 102, 't', 'f', NULL, NULL, NULL, NULL, '2025-07-10 16:37:18.699303', '2025-06-18 10:51:19.56', '2025-06-18 10:51:19.56');
INSERT INTO "public"."users" VALUES (9, 'sufiana', 'sufiana@gmail.com', '$2b$10$kPh.xMnBoYsbh2PIx3PVkuY4Xvewq2sd9XAZHrkzwfz1d6fP02rXK', NULL, NULL, NULL, 2, 101, 't', 'f', NULL, NULL, NULL, NULL, NULL, '2025-06-18 13:00:50.921124', '2025-06-18 13:00:50.921124');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."evaluasi_kuesioner_id_seq"
OWNED BY "public"."evaluasi_kuesioner"."id";
SELECT setval('"public"."evaluasi_kuesioner_id_seq"', 22, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."hasil_kuesioner_id_seq"
OWNED BY "public"."hasil_kuesioner"."id";
SELECT setval('"public"."hasil_kuesioner_id_seq"', 326, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."kegiatan_siswa_id_seq"
OWNED BY "public"."kegiatan_siswa"."id";
SELECT setval('"public"."kegiatan_siswa_id_seq"', 2, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."parameter_kebersihan_id_seq"
OWNED BY "public"."parameter_kebersihan"."id";
SELECT setval('"public"."parameter_kebersihan_id_seq"', 98, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."penilaian_kuesioner_id_seq"
OWNED BY "public"."penilaian_kuesioner"."id";
SELECT setval('"public"."penilaian_kuesioner_id_seq"', 2, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."role_id_seq"
OWNED BY "public"."role"."id";
SELECT setval('"public"."role_id_seq"', 9, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."ruang_sekolah_1_id_seq"
OWNED BY "public"."ruang_sekolah_1"."id";
SELECT setval('"public"."ruang_sekolah_1_id_seq"', 18, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."ruang_sekolah_id_seq"
OWNED BY "public"."ruang_sekolah"."id";
SELECT setval('"public"."ruang_sekolah_id_seq"', 18, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."users_id_seq"
OWNED BY "public"."users"."id";
SELECT setval('"public"."users_id_seq"', 21, true);

-- ----------------------------
-- Primary Key structure for table evaluasi_kuesioner
-- ----------------------------
ALTER TABLE "public"."evaluasi_kuesioner" ADD CONSTRAINT "evaluasi_kuesioner_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table hasil_kuesioner
-- ----------------------------
ALTER TABLE "public"."hasil_kuesioner" ADD CONSTRAINT "hasil_kuesioner_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table kegiatan_siswa
-- ----------------------------
ALTER TABLE "public"."kegiatan_siswa" ADD CONSTRAINT "kegiatan_siswa_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table parameter_kebersihan
-- ----------------------------
ALTER TABLE "public"."parameter_kebersihan" ADD CONSTRAINT "parameter_kebersihan_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table penilaian_kuesioner
-- ----------------------------
ALTER TABLE "public"."penilaian_kuesioner" ADD CONSTRAINT "penilaian_kuesioner_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table role
-- ----------------------------
ALTER TABLE "public"."role" ADD CONSTRAINT "role_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table ruang_sekolah
-- ----------------------------
ALTER TABLE "public"."ruang_sekolah" ADD CONSTRAINT "ruang_sekolah_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table ruang_sekolah_1
-- ----------------------------
ALTER TABLE "public"."ruang_sekolah_1" ADD CONSTRAINT "ruang_sekolah_pkey_1" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table sekolah
-- ----------------------------
ALTER TABLE "public"."sekolah" ADD CONSTRAINT "sekolah_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table session
-- ----------------------------
CREATE INDEX "IDX_session_expire" ON "public"."session" USING btree (
  "expire" "pg_catalog"."timestamp_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table session
-- ----------------------------
ALTER TABLE "public"."session" ADD CONSTRAINT "session_pkey" PRIMARY KEY ("sid");

-- ----------------------------
-- Checks structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "login_method_check" CHECK (((password_hash IS NOT NULL) OR (google_id IS NOT NULL)));

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("id");
