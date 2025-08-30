<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Export: sekolah_bersih - localhost:5432 - Adminer</title>
<link rel="stylesheet" href="adminer.php?file=default.css&amp;version=5.3.0">
<link rel='stylesheet' media='(prefers-color-scheme: dark)' href='adminer.php?file=dark.css&amp;version=5.3.0'>
<meta name='color-scheme' content='light dark'>
<script src='adminer.php?file=functions.js&amp;version=5.3.0' nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ="></script>
<link rel='icon' href='data:image/gif;base64,R0lGODlhEAAQAJEAAAQCBPz+/PwCBAROZCH5BAEAAAAALAAAAAAQABAAAAI2hI+pGO1rmghihiUdvUBnZ3XBQA7f05mOak1RWXrNq5nQWHMKvuoJ37BhVEEfYxQzHjWQ5qIAADs='>
<link rel='apple-touch-icon' href='adminer.php?file=logo.png&amp;version=5.3.0'>

<body class='ltr nojs adminer'>
<script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick});
document.body.classList.replace('nojs', 'js');
const offlineMessage = 'You are offline.';
const thousandsSeparator = ',';</script>
<div id='help' class='jush-pgsql jsonly hidden'></div>
<script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">mixin(qs('#help'), {onmouseover: () => { helpOpen = 1; }, onmouseout: helpMouseout});</script>
<div id='content'>
<span id='menuopen' class='jsonly'><button type='submit' name='' title='' class='icon icon-move'><span>menu</span></button></span><script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">qs('#menuopen').onclick = event => { qs('#foot').classList.toggle('foot'); event.stopPropagation(); }</script>
<p id="breadcrumb"><a href="adminer.php?pgsql=localhost%3A5432">PostgreSQL</a> » <a href='adminer.php?pgsql=localhost%3A5432&amp;username=sekolah_bersih' accesskey='1' title='Alt+Shift+1'>localhost:5432</a> » <a href="adminer.php?pgsql=localhost%3A5432&amp;username=sekolah_bersih&amp;db=sekolah_bersih&amp;ns=">sekolah_bersih</a> » Export
<h2>Export: sekolah_bersih</h2>
<div id='ajaxstatus' class='jsonly hidden'></div>

<form action="" method="post">
<table class="layout">
<tr><th>Output<td><label><input type='radio' name='output' value='text' checked>open</label><label><input type='radio' name='output' value='file'>save</label><label><input type='radio' name='output' value='gz'>gzip</label>
<tr><th>Format<td><label><input type='radio' name='format' value='sql' checked>SQL</label><label><input type='radio' name='format' value='csv'>CSV,</label><label><input type='radio' name='format' value='csv;'>CSV;</label><label><input type='radio' name='format' value='tsv'>TSV</label>
<tr><th>Database<td><select name='db_style'><option selected><option>USE<option>DROP+CREATE<option>CREATE</select><label><input type='checkbox' name='types' value='1'>User types</label><label><input type='checkbox' name='routines' value='1' checked>Routines</label><tr><th>Tables<td><select name='table_style'><option><option selected>DROP+CREATE<option>CREATE</select><label><input type='checkbox' name='auto_increment' value='1'>Auto Increment</label><label><input type='checkbox' name='triggers' value='1' checked>Triggers</label><tr><th>Data<td><select name='data_style'><option><option>TRUNCATE+INSERT<option selected>INSERT</select></table>
<p><input type="submit" value="Export">
<input type='hidden' name='token' value='284748:787619'>

<table>
<script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">qsl('table').onclick = dumpClick;</script>
<thead><tr><th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables' checked>Tables</label><script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">qs('#check-tables').onclick = partial(formCheck, /^tables\[/);</script><th style='text-align: right;'><label class='block'>Data<input type='checkbox' id='check-data' checked></label><script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">qs('#check-data').onclick = partial(formCheck, /^data\[/);</script></thead>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='cabdis' checked>cabdis</label><td align='right'><label class='block'><span id='Rows-cabdis'></span><input type='checkbox' name='data[]' value='cabdis' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='evaluasi_kuesioner' checked>evaluasi_kuesioner</label><td align='right'><label class='block'><span id='Rows-evaluasi_kuesioner'></span><input type='checkbox' name='data[]' value='evaluasi_kuesioner' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='evaluasi_pengawas' checked>evaluasi_pengawas</label><td align='right'><label class='block'><span id='Rows-evaluasi_pengawas'></span><input type='checkbox' name='data[]' value='evaluasi_pengawas' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='failed_jobs' checked>failed_jobs</label><td align='right'><label class='block'><span id='Rows-failed_jobs'></span><input type='checkbox' name='data[]' value='failed_jobs' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='hasil_kuesioner' checked>hasil_kuesioner</label><td align='right'><label class='block'><span id='Rows-hasil_kuesioner'></span><input type='checkbox' name='data[]' value='hasil_kuesioner' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='kabupaten' checked>kabupaten</label><td align='right'><label class='block'><span id='Rows-kabupaten'></span><input type='checkbox' name='data[]' value='kabupaten' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='kegiatan_siswa' checked>kegiatan_siswa</label><td align='right'><label class='block'><span id='Rows-kegiatan_siswa'></span><input type='checkbox' name='data[]' value='kegiatan_siswa' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='migrations' checked>migrations</label><td align='right'><label class='block'><span id='Rows-migrations'></span><input type='checkbox' name='data[]' value='migrations' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='parameter_kebersihan' checked>parameter_kebersihan</label><td align='right'><label class='block'><span id='Rows-parameter_kebersihan'></span><input type='checkbox' name='data[]' value='parameter_kebersihan' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='parameter_kebersihan_1' checked>parameter_kebersihan_1</label><td align='right'><label class='block'><span id='Rows-parameter_kebersihan_1'></span><input type='checkbox' name='data[]' value='parameter_kebersihan_1' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='penilaian_kuesioner' checked>penilaian_kuesioner</label><td align='right'><label class='block'><span id='Rows-penilaian_kuesioner'></span><input type='checkbox' name='data[]' value='penilaian_kuesioner' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='ref_jabatan_verifikator' checked>ref_jabatan_verifikator</label><td align='right'><label class='block'><span id='Rows-ref_jabatan_verifikator'></span><input type='checkbox' name='data[]' value='ref_jabatan_verifikator' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='role' checked>role</label><td align='right'><label class='block'><span id='Rows-role'></span><input type='checkbox' name='data[]' value='role' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='ruang_sekolah' checked>ruang_sekolah</label><td align='right'><label class='block'><span id='Rows-ruang_sekolah'></span><input type='checkbox' name='data[]' value='ruang_sekolah' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='ruang_sekolah_1' checked>ruang_sekolah_1</label><td align='right'><label class='block'><span id='Rows-ruang_sekolah_1'></span><input type='checkbox' name='data[]' value='ruang_sekolah_1' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='sekolah' checked>sekolah</label><td align='right'><label class='block'><span id='Rows-sekolah'></span><input type='checkbox' name='data[]' value='sekolah' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='session' checked>session</label><td align='right'><label class='block'><span id='Rows-session'></span><input type='checkbox' name='data[]' value='session' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbot_user' checked>tbot_user</label><td align='right'><label class='block'><span id='Rows-tbot_user'></span><input type='checkbox' name='data[]' value='tbot_user' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='users' checked>users</label><td align='right'><label class='block'><span id='Rows-users'></span><input type='checkbox' name='data[]' value='users' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='users_new' checked>users_new</label><td align='right'><label class='block'><span id='Rows-users_new'></span><input type='checkbox' name='data[]' value='users_new' checked></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='verifikator_sekolah' checked>verifikator_sekolah</label><td align='right'><label class='block'><span id='Rows-verifikator_sekolah'></span><input type='checkbox' name='data[]' value='verifikator_sekolah' checked></label>
<script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">ajaxSetHtml('adminer.php?pgsql=localhost%3A5432&username=sekolah_bersih&db=sekolah_bersih&ns=&script=db');</script>
</table>
</form>
<p><a href='adminer.php?pgsql=localhost%3A5432&amp;username=sekolah_bersih&amp;db=sekolah_bersih&amp;ns=&amp;dump=evaluasi%25'>evaluasi</a> <a href='adminer.php?pgsql=localhost%3A5432&amp;username=sekolah_bersih&amp;db=sekolah_bersih&amp;ns=&amp;dump=parameter%25'>parameter</a> <a href='adminer.php?pgsql=localhost%3A5432&amp;username=sekolah_bersih&amp;db=sekolah_bersih&amp;ns=&amp;dump=ruang%25'>ruang</a> <a href='adminer.php?pgsql=localhost%3A5432&amp;username=sekolah_bersih&amp;db=sekolah_bersih&amp;ns=&amp;dump=users%25'>users</a></div>

<div id='foot' class='foot'>
<div id='menu'>
<h1><a href='https://www.adminer.org/' target="_blank" rel="noreferrer noopener" id='h1'><img src='adminer.php?file=logo.png&amp;version=5.3.0' width='24' height='24' alt='' id='logo'>Adminer</a> <span class='version'>5.3.0 <a href='https://www.adminer.org/#download' target="_blank" rel="noreferrer noopener" id='version'></a></span></h1>
<script src='adminer.php?file=jush.js&amp;version=5.3.0' nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=" defer></script>
<script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">
</script>
<script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">syntaxHighlighting('15', '');</script>
<form action=''>
<p id='dbs'>
<input type='hidden' name='pgsql' value='localhost:5432'>
<input type='hidden' name='username' value='sekolah_bersih'>
<label title='Database'>DB: <select name='db'><option value=""><option>postgres<option selected>sekolah_bersih<option>sekolahbersih<option>sumber_didik<option>template1</select><script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});</script>
</label><input type='submit' value='Use' class='hidden'>
<br><label>Schema: <select name='ns'><option value="" selected><option>information_schema<option>pg_catalog<option>pg_toast<option>public</select><script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});</script>
</label><input type='hidden' name='dump' value=''>
</p></form>
<p class='links'>
<a href='adminer.php?pgsql=localhost%3A5432&amp;username=sekolah_bersih&amp;db=sekolah_bersih&amp;ns=&amp;sql='>SQL command</a>
<a href='adminer.php?pgsql=localhost%3A5432&amp;username=sekolah_bersih&amp;db=sekolah_bersih&amp;ns=&amp;import='>Import</a>
<a href='adminer.php?pgsql=localhost%3A5432&amp;username=sekolah_bersih&amp;db=sekolah_bersih&amp;ns=&amp;dump=' id='dump' class='active '>Export</a>
</div>
<form action="" method="post">
<p class="logout">
<span>sekolah_bersih
</span>
<input type="submit" name="logout" value="Logout" id="logout">
<input type='hidden' name='token' value='637196:124387'>
</form>
</div>

<script nonce="NGI2ZmZhOWRhZDIxMjdiMjBkODEyYzNhMmUwYzEzYTQ=">setupSubmitHighlight(document);</script>
