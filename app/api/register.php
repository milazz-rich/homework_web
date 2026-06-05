<?php

require_once __DIR__ . '/../services/AuthService.php';

if (isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email']) && isset($_POST['password'])) {
    try {
        $authService = new AuthService();
        $authService->register($_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['password']);

        header('Location: ../../login.php');
        exit;
    } catch (Throwable $e) {
        $error = true;
    }
} else {
    $error = true;
}
