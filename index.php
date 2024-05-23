<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$content = 'templates/index.html';
include 'templates/base.html';

