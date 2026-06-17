<?php
/**
 * Entry Point Utama - Sistem Informasi Tahfidz
 * Bypass rute langsung ke login jika belum ada session aktif
 */

session_start();

// Jika sudah memiliki session login aktif, arahkan sesuai role
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $basePath = rtrim(dirname($scriptName), '/');

    switch ($_SESSION['role']) {
        case 'admin':
            header('Location: ' . $basePath . '/views/admin/dashboard.html');
            exit;
        case 'guru':
            header('Location: ' . $basePath . '/views/guru/beranda.html');
            exit;
        case 'wali_murid':
            header('Location: ' . $basePath . '/views/wali_murid/beranda.html');
            exit;
        default:
            session_destroy();
            break;
    }
}

// JIKA BELUM LOGIN (Atau default): Langsung muat/panggil file login tanpa redirect URL
// Cara ini dijamin 100% menghentikan looping rute pada Vercel
include_once(__DIR__ . '/views/shared/login.html');
exit;