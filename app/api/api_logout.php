<?php

require_once __DIR__ . '/../services/AuthService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $authService = new AuthService();
    $authService->logout();
}

header('Location: ../../index.php');
exit;
