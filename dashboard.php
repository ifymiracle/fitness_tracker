<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

$content = 'templates/dashboard.html';
include 'templates/base.html';

