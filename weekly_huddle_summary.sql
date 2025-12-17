--refresh di airflow
agg_kpi_npac_payload
agg_kpi_npac_revenue_lacci
agg_region_kpi_npac_payload_daily
agg_region_kpi_npac_weekly_1_percent
agg_region_kpi_util_prb
kpi_npac_ows_avail_ne
kpi_npac_availabilty_achievement
kpi_npac_pu_cb_rgb_du_daily





select "date"  , sum(payload_mbyte)
from sumatera.tb_payload_traffic_site_dd_src_rancell 
where "date" >= '2025-06-01' 
group by 1


--prepare check
SELECT yearweek, "date", site_id, payload_mbyte_2g, payload_mbyte_3g, payload_mbyte_4g, payload_mbyte_5g, payload_mbyte, traffic_erl_2g, traffic_erl_3g, traffic_erl_4g, traffic_erl_5g, traffic_erl, kecamatan, kabupaten, "cluster", district_operation_do, branch, departement_ns, region
FROM sumatera.tb_payload_traffic_site_dd_src_rancell
where "date" ='2025-08-31'

-- delete tanggal tersebut
delete from sumatera.tb_payload_traffic_site_dd_src_rancell
where "date" ='2025-08-31'


--insert used 1 week before
insert into sumatera.tb_payload_traffic_site_dd_src_rancell (yearweek, "date", site_id, payload_mbyte_2g, payload_mbyte_3g, payload_mbyte_4g, payload_mbyte_5g, payload_mbyte, traffic_erl_2g, traffic_erl_3g, traffic_erl_4g, traffic_erl_5g, traffic_erl, kecamatan, kabupaten, "cluster", district_operation_do, branch, departement_ns, region
)
SELECT '202535' as yearweek, '2025-08-31' as "date", 
site_id, payload_mbyte_2g, payload_mbyte_3g, payload_mbyte_4g, payload_mbyte_5g, payload_mbyte, traffic_erl_2g, traffic_erl_3g, traffic_erl_4g, traffic_erl_5g, traffic_erl, kecamatan, kabupaten, "cluster", district_operation_do, branch, departement_ns, region
FROM sumatera.tb_payload_traffic_site_dd_src_rancell
where "date" ='2025-08-24'

	
	
	
--Halaman 1
	

--revenue Bn
SELECT yearweek, region, round(revenue_lacci::numeric/1000000000,2) as revenue_lacci 
FROM npac.agg_region_kpi_revenue_lacci_weekly
where yearweek >= '202401'
order by yearweek desc




--payload pb
SELECT region, pay_week, round(payload_total_mbyte::numeric/(1024*1024*1024),2) as pay_pb
FROM npac.agg_region_kpi_payload_weekly
where pay_week >= '202401'
and region notnull
order by pay_week desc




--subs
with cte as (
	SELECT "date", region, cb as cb_last, rgb as rgb_last, 
	rgb_data as rgb_data_last, rgb_digital as rgb_digital_last, payload_user as payload_user_last, datauser as datauser_last
	FROM npac.agg_region_kpi_pu_cb_rgb_du_daily a
	where "date" ='2025-06-30'
),
cte_after as (
	SELECT "date", region,cb, rgb, rgb_data, rgb_digital, payload_user, datauser
	FROM npac.agg_region_kpi_pu_cb_rgb_du_daily a
	where "date" ='2025-07-31'
)
select a.region ,cb_last, cb,rgb_last, rgb, rgb_data_last,rgb_data, rgb_digital_last,rgb_digital, 
payload_user_last,payload_user, datauser_last,datauser
from cte a
left join cte_after b
on a.region = b.region



-- ava pop ach
with cte as (
	SELECT week, site_id, region,
	 "class",  ava_ne ,
	 CASE
	    WHEN "class" = 'Diamond' AND ava_ne >= 99.4 THEN 'meet'
	    WHEN "class" = 'Diamond' AND ava_ne < 99.4 THEN 'not_meet'
	    WHEN "class" = 'Platinum' AND ava_ne >= 99 THEN 'meet'
	    WHEN "class" = 'Platinum' AND ava_ne < 99 THEN 'not_meet'
	    WHEN "class" = 'Gold' AND ava_ne >= 98.2 THEN 'meet'
	    WHEN "class" = 'Gold' AND ava_ne < 98.2 THEN 'not_meet'
	    WHEN "class" = 'Silver' AND ava_ne >= 97 THEN 'meet'
	    WHEN "class" = 'Silver' AND ava_ne < 97 THEN 'not_meet'
	    WHEN "class" = 'Bronze' AND ava_ne >= 95 THEN 'meet'
	    WHEN "class" = 'Bronze' AND ava_ne < 95 THEN 'not_meet'
	    ELSE NULL
	END AS status_ava
	FROM npac.kpi_npac_availabilty_achievement_ne
	where week >= '202401'
),
cte1 as (
	select week,region,
	sum(case 
		when status_ava = 'meet' then 1
		else 0
	end) as meet,
	sum(case 
		when status_ava = 'not_meet' then 1
		else 0
	end) as not_meet
	from cte
	group by 1,2
)
select * 
from cte1
where region notnull
order by week DESC




--pl
sELECT region, yearweek,  perc_pl
FROM npac.agg_region_kpi_pl_1_percent_weekly
where yearweek >='202401'
order by yearweek desc


--prb
SELECT week_util, region, prb
FROM npac.agg_region_kpi_prb_sector
where week_util >= '202401'
order by week_util desc



--RCI
SELECT a.region ,a.week, remark_redsector_final,
case 
	when remark_redsector_final = '1. Direct Investment' then 'Direct_invest'
	when remark_redsector_final = '2. a. Direct Investment Flow Distribution' then 'Direct_invest'
	when remark_redsector_final = '2. b. Non-Direct to Direct Investment' then 'Direct_invest'
	when remark_redsector_final = '3. a. Direct Optim Fast Track to Direct Investment' then 'Direct_invest'
	when remark_redsector_final = '3. b. Direct Optim Done to Direct Investment' then 'Direct_invest'
	when remark_redsector_final = '3. c. Direct Optim to Direct Operation' then 'Operation'
	when remark_redsector_final = '3. d. Direct Optim to Direct Optim' then 'Optim'
	when remark_redsector_final = '4. Escalation to RAN Vendor' then 'Ran_vendor'
	when remark_redsector_final = 'Green Sector' then 'Green Sector'
end as cat_info
, count(a.site_id)
FROM region_nationwide.capacity_redsector_4g_week a
left join region_nationwide.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
on a.site_id = b.site_id 
where a.week >='202501'
and a.region in ('SUMBAGUT','SUMBAGTENG','SUMBAGSEL')
group by 1,2,3




--good quality_from kab
select region as location,yearweek ,operator,
SUM(good_quality_num::numeric) as good_quality_num,
SUM(good_quality_denum::numeric) as good_quality_denum,
round((SUM(good_quality_num::numeric)/SUM(good_quality_denum::numeric))*100,2) as good_quality
from region_nationwide.tutela_border_month a
left join region_nationwide.location_id_city b
on a."location" = b."location" 
where "level" ='kabupaten' and node ='4G'
and yearweek >= '202401'  
and a.region in ('SUMBAGUT','SUMBAGTENG','SUMBAGSEL')
group by 1,2,3
order by yearweek DESC


--game parameter from kab
select  region as location,yearweek ,operator,
SUM(game_parameter_num::numeric) as game_parameter_num,
SUM(game_parameter_denum::numeric) as game_parameter_denum,
round((SUM(game_parameter_num::numeric)/SUM(game_parameter_denum::numeric))*100,2) as game_parameter
from region_nationwide.tutela_border_month
where "level" ='kabupaten' and node ='4G'
and yearweek >= '202401'  
and region in ('SUMBAGUT','SUMBAGTENG','SUMBAGSEL')
group by 1,2,3
order by yearweek desc







--Halaman 2


--priority not priority

--prb tinggal rubah in or not in
select a.week_util  ,b.region, (sum(sector_prb_util_num)/sum(sector_prb_util_denum))*100 as prb FROM npac.kpi_prb_util4g_sector a
left join sumatera.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
on a.site_id = b.site_id 
where a.week_util >='202401'
and b.id_kab  in ('1115','1106','1117','1113','1171','1105','1111','1275','1212','1225','1214','1202','1203','1204','1205','1104','1210','1211','1215','1217','1206','1219','1208','1207','1220','2171','1408','1406','1401','1409','1407','1371','1302','1310','1403','1402','1471','1404','1405','1604','1502','1571','1505','1504','1503','1507','1509','1508','1871','1803','1671','1602')
group by 1,2
union all 
select a.week_util  ,'SUMATERA' as region , (sum(sector_prb_util_num)/sum(sector_prb_util_denum))*100 as prb FROM npac.kpi_prb_util4g_sector a
left join sumatera.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
on a.site_id = b.site_id 
where a.week_util >='202401'
and b.id_kab in ('1115','1106','1117','1113','1171','1105','1111','1275','1212','1225','1214','1202','1203','1204','1205','1104','1210','1211','1215','1217','1206','1219','1208','1207','1220','2171','1408','1406','1401','1409','1407','1371','1302','1310','1403','1402','1471','1404','1405','1604','1502','1571','1505','1504','1503','1507','1509','1508','1871','1803','1671','1602')
group by 1,2
order by week_util desc


--RCI tinggal rubah in or not in
SELECT a.region ,a.week, remark_redsector_final,
case 
	when remark_redsector_final = '1. Direct Investment' then 'Direct_invest'
	when remark_redsector_final = '2. a. Direct Investment Flow Distribution' then 'Direct_invest'
	when remark_redsector_final = '2. b. Non-Direct to Direct Investment' then 'Direct_invest'
	when remark_redsector_final = '3. a. Direct Optim Fast Track to Direct Investment' then 'Direct_invest'
	when remark_redsector_final = '3. b. Direct Optim Done to Direct Investment' then 'Direct_invest'
	when remark_redsector_final = '3. c. Direct Optim to Direct Operation' then 'Operation'
	when remark_redsector_final = '3. d. Direct Optim to Direct Optim' then 'Optim'
	when remark_redsector_final = '4. Escalation to RAN Vendor' then 'Ran_vendor'
	when remark_redsector_final = 'Green Sector' then 'Green Sector'
end as cat_info
, count(a.site_id)
FROM region_nationwide.capacity_redsector_4g_week a
left join region_nationwide.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
on a.site_id = b.site_id 
where a.week >='202501'
and a.region in ('SUMBAGUT','SUMBAGTENG','SUMBAGSEL')
and b.id_kab not In ('1115','1106','1117','1113','1171','1105','1111','1275','1212','1225','1214','1202','1203','1204','1205','1104','1210','1211','1215','1217','1206','1219','1208','1207','1220','2171','1408','1406','1401','1409','1407','1371','1302','1310','1403','1402','1471','1404','1405','1604','1502','1571','1505','1504','1503','1507','1509','1508','1871','1803','1671','1602')
group by 1,2,3



--good quality tinggal rubah in or not in
select a."location",region,yearweek ,operator,
SUM(good_quality_num::numeric) as good_quality_num,
SUM(good_quality_denum::numeric) as good_quality_denum,
round((SUM(good_quality_num::numeric)/SUM(good_quality_denum::numeric))*100,2) as good_quality
from region_nationwide.tutela_border_month a
left join region_nationwide.location_id_city b
on a."location" = b."location" 
where "level" ='kabupaten' and node ='4G'
and yearweek >= '202401'  
and region in ('SUMBAGUT','SUMBAGTENG','SUMBAGSEL')
and b.location_id not in ('1115','1106','1117','1113','1171','1105','1111','1275','1212','1225','1214','1202','1203','1204','1205','1104','1210','1211','1215','1217','1206','1219','1208','1207','1220','2171','1408','1406','1401','1409','1407','1371','1302','1310','1403','1402','1471','1404','1405','1604','1502','1571','1505','1504','1503','1507','1509','1508','1871','1803','1671','1602')
group by 1,2,3,4
order by yearweek desc









--game parameter tinggal rubah in or not in
select  a."location",region,yearweek ,operator,
SUM(game_parameter_num::numeric) as game_parameter_num,
SUM(game_parameter_denum::numeric) as game_parameter_denum,
round((SUM(game_parameter_num::numeric)/SUM(game_parameter_denum::numeric))*100,2) as game_parameter
from region_nationwide.tutela_border_month a
left join region_nationwide.location_id_city b
on a."location" = b."location" 
where "level" ='kabupaten' and node ='4G'
and yearweek >= '202401'  
and region in ('SUMBAGUT','SUMBAGTENG','SUMBAGSEL')
and b.location_id not in ('1115','1106','1117','1113','1171','1105','1111','1275','1212','1225','1214','1202','1203','1204','1205','1104','1210','1211','1215','1217','1206','1219','1208','1207','1220','2171','1408','1406','1401','1409','1407','1371','1302','1310','1403','1402','1471','1404','1405','1604','1502','1571','1505','1504','1503','1507','1509','1508','1871','1803','1671','1602')
group by 1,2,3,4
order by yearweek desc





--Halaman 3

--daily actual
select region as teritory ,concat(to_char("date",'YYYY'),to_char("date",'mm')) as yearmonth, avg(payload_mbyte_last) as payload_mbyte_last, avg(traffic_erl_last) as traffic_erl_last 
	from (
		select b.region ,
		"date",
		sum(payload_mbyte) as payload_mbyte_last  , sum(traffic_erl) as traffic_erl_last
		from sumatera.tb_payload_traffic_site_dd_src_rancell a
		left join sumatera.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
		on a.site_id = b.site_id 
		left join sumatera.mapping_teritory_city_nop_v2024 c
		on b.id_kab::numeric = c.id_kab::numeric 
		where "date" >='2023-01-01' and "date" <='2025-08-28'
		and b.region notnull
		group by 1,2
	)a
	group by 1,2
union all 
select teritory ,concat(to_char("date",'YYYY'),to_char("date",'mm')) as yearmonth, avg(payload_mbyte_last) as payload_mbyte_last, avg(traffic_erl_last) as traffic_erl_last 
	from (
		select 'SUMATERA' as teritory ,
		"date",
		sum(payload_mbyte) as payload_mbyte_last  , sum(traffic_erl) as traffic_erl_last
		from sumatera.tb_payload_traffic_site_dd_src_rancell a
		left join sumatera.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
		on a.site_id = b.site_id 
		left join sumatera.mapping_teritory_city_nop_v2024 c
		on b.id_kab::numeric = c.id_kab::numeric 
		where "date" >='2023-01-01' and "date" <='2025-08-28'
		and b.region notnull
		group by 1,2
	)a
	group by 1,2
	
	
	
	
--region_mom
with cte_region as (
	select region as teritory , avg(payload_mbyte_last) as payload_mbyte_last, avg(traffic_erl_last) as traffic_erl_last 
	from (
		select b.region ,
		"date",
		sum(payload_mbyte) as payload_mbyte_last  , sum(traffic_erl) as traffic_erl_last
		from sumatera.tb_payload_traffic_site_dd_src_rancell a
		left join sumatera.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
		on a.site_id = b.site_id 
		left join sumatera.mapping_teritory_city_nop_v2024 c
		on b.id_kab::numeric = c.id_kab::numeric 
		where "date" >='2025-07-01' and "date" <='2025-07-28'
		and b.region notnull
		group by 1,2
	)a
	group by 1
),
cte1_region as (
	select region as teritory , avg(payload_mbyte) as payload_mbyte, avg(traffic_erl) as traffic_erl 
	from (
		select b.region ,
		"date",
		sum(payload_mbyte) as payload_mbyte  , sum(traffic_erl) as traffic_erl
		from sumatera.tb_payload_traffic_site_dd_src_rancell a
		left join sumatera.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
		on a.site_id = b.site_id 
		left join sumatera.mapping_teritory_city_nop_v2024 c
		on b.id_kab::numeric = c.id_kab::numeric 
		where "date" >='2025-08-01' and "date" <='2025-08-28'
		and b.region notnull
		group by 1,2
	)a
	group by 1
)
select a.teritory , '' as id_teritory, b.teritory as region , 'region' as "level",
	payload_mbyte,
	payload_mbyte_last,
	round(((payload_mbyte::numeric - payload_mbyte_last::numeric)/payload_mbyte_last::numeric)*100,2) as mom_pay,
	traffic_erl,
	traffic_erl_last,
	round(((traffic_erl::numeric - traffic_erl_last::numeric)/traffic_erl_last::numeric)*100,2) as mom_tra
	from cte_region a 
	left join cte1_region b
	on a.teritory = b.teritory
	union all
	select 'SUMATERA' as teritory , '' as id_teritory, 'SUMATERA' as region , 'area' as "level",
	sum(payload_mbyte) as payload_mbyte,
	sum(payload_mbyte_last) as payload_mbyte_last,
	round(((sum(payload_mbyte)::numeric - sum(payload_mbyte_last)::numeric)/sum(payload_mbyte_last)::numeric)*100,2) as mom_pay,
	sum(traffic_erl) as traffic_erl,
	sum(traffic_erl_last) as traffic_erl_last,
	round(((sum(traffic_erl)::numeric - sum(traffic_erl_last)::numeric)/sum(traffic_erl_last)::numeric)*100,2) as mom_tra
	from cte_region a 
	left join cte1_region b
	on a.teritory = b.teritory
	
	
--ytd region
select region ,date_pay ,ytd_payload_total_mbyte_perc 
	from npac.agg_region_kpi_payload_ytd_daily a
	where date_pay ='2025-08-28'


--daily actual city
with cte_daily as (
	select a.id_kab,c.region, c.kabupaten ,concat(to_char("date",'YYYY'),to_char("date",'mm')) as yearmonth, 
	(avg(payload_mbyte_last))/(1024*1024*1024) as payload_pb
		from (
			select b.id_kab ,
			"date",
			sum(payload_mbyte) as payload_mbyte_last  , sum(traffic_erl) as traffic_erl_last
			from sumatera.tb_payload_traffic_site_dd_src_rancell a
			left join sumatera.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
			on a.site_id = b.site_id 
			left join sumatera.mapping_teritory_city_nop_v2024 c
			on b.id_kab::numeric = c.id_kab::numeric 
			where "date" >='2025-08-01' and "date" <='2025-08-28'
			and b.region notnull
			group by 1,2
		)a
		left join sumatera.mapping_teritory_city_nop_v2024 c
		on a.id_kab::numeric = c.id_kab::numeric
		group by 1,2,3,4
),
cte_yoy as (
	select a.id_kab , c.kabupaten ,concat(to_char("date",'YYYY'),to_char("date",'mm')) as yearmonth, 
	(avg(payload_mbyte_last))/(1024*1024*1024) as payload_pb_yoy
		from (
			select b.id_kab ,
			"date",
			sum(payload_mbyte) as payload_mbyte_last  , sum(traffic_erl) as traffic_erl_last
			from sumatera.tb_payload_traffic_site_dd_src_rancell a
			left join sumatera.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
			on a.site_id = b.site_id 
			left join sumatera.mapping_teritory_city_nop_v2024 c
			on b.id_kab::numeric = c.id_kab::numeric 
			where "date" >='2024-08-01' and "date" <='2024-08-28'
			and b.region notnull
			group by 1,2
		)a
		left join sumatera.mapping_teritory_city_nop_v2024 c
		on a.id_kab::numeric = c.id_kab::numeric
		group by 1,2,3
),
cte_mom as (
	select a.id_kab , c.kabupaten ,concat(to_char("date",'YYYY'),to_char("date",'mm')) as yearmonth, 
	(avg(payload_mbyte_last))/(1024*1024*1024) as payload_pb_mom
		from (
			select b.id_kab ,
			"date",
			sum(payload_mbyte) as payload_mbyte_last  , sum(traffic_erl) as traffic_erl_last
			from sumatera.tb_payload_traffic_site_dd_src_rancell a
			left join sumatera.mapping_sysinfo_geohash_onair_and_dismantle_v1 b
			on a.site_id = b.site_id 
			left join sumatera.mapping_teritory_city_nop_v2024 c
			on b.id_kab::numeric = c.id_kab::numeric 
			where "date" >='2025-07-01' and "date" <='2025-07-28'
			and b.region notnull
			group by 1,2
		)a
		left join sumatera.mapping_teritory_city_nop_v2024 c
		on a.id_kab::numeric = c.id_kab::numeric
		group by 1,2,3
),
cte_ytd as (
	select b.location_id as id_kab, a.kabupaten , ytd_payload_total_mbyte_perc as ytd
	from npac.agg_kabupaten_kpi_payload_ytd_daily a
	left join npac.tutela_id_kabupaten b
	on a.kabupaten = b.kab_v28
	where date_pay ='2025-08-28'
)
select a.yearmonth, a.region ,a.id_kab , a.kabupaten, 
round(payload_pb,2) as pay_avg_daily_pb,
round(((payload_pb::numeric - payload_pb_mom::numeric)/payload_pb_mom::numeric)*100,2) as mom,
round(((payload_pb::numeric - payload_pb_yoy::numeric)/payload_pb_yoy::numeric)*100,2) as yoy,
ytd
from cte_daily a
left join cte_mom b
on a.id_kab = b.id_kab
left join cte_yoy c
on a.id_kab = c.id_kab
left join cte_ytd d
on a.id_kab::numeric = d.id_kab::numeric




	
	
