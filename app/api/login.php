<?php

require_once __DIR__ . '/../services/AuthService.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    try {
        $authService = new AuthService();
        $authService->login($_POST['email'], $_POST['password']);
        header('Location: ../../index.php');
        exit;
    } catch (Throwable $e) {
        $error = true;
    }
} else {
    $error = true;
}
