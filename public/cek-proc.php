<?php
if (function_exists('proc_open')) {
    echo "<h1 style='color:green'>✅ proc_open: AKTIF</h1>";
} else {
    echo "<h1 style='color:red'>❌ proc_open: DINONAKTIFKAN</h1>";
}

// Tampilkan daftar fungsi yang diblokir
$disabled = ini_get('disable_functions');
echo "<h3>disable_functions:</h3>";
echo "<pre>" . htmlspecialchars($disabled ?: 'Tidak ada fungsi yang diblokir') . "</pre>";
?>