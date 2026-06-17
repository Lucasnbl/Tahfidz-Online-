<?php
/**
 * Entry Point Utama - Sistem Informasi Tahfidz
 * Redirect berdasarkan role pengguna dengan proteksi loop Vercel
 */

session_start();

// Deteksi base path dari URL request
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = rtrim(dirname($scriptName), '/');

// Ambil URL yang sedang diakses saat ini
$requestUri = $_SERVER['REQUEST_URI'];

// JIKA USER SEDANG MENGAKSES HALAMAN LOGIN ATAU ASET, JANGAN DI-REDIRECT LAGI!
if (strpos($requestUri, 'login.html') !== false || strpos($requestUri, '/assets/') !== false) {
    // Biarkan Vercel meneruskan untuk membaca file asli login.html
    include_once(__DIR__ . '/views/shared/login.html');
    exit;
}

// Jika belum login, redirect ke halaman login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ' . $basePath . '/views/shared/login.html');
    exit;
}

// Redirect berdasarkan role jika sudah login
switch ($_SESSION['role']) {
    case 'admin':
        header('Location: ' . $basePath . '/views/admin/dashboard.html');
        break;
    case 'guru':
        header('Location: ' . $basePath . '/views/guru/beranda.html');
        break;
    case 'wali_murid':
        header('Location: ' . $basePath . '/views/wali_murid/beranda.html');
        break;
    default:
        session_destroy();
        header('Location: ' . $basePath . '/views/shared/login.html');
        break;
}
exit;