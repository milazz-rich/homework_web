<?php

require_once __DIR__ . '/../services/AuthService.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../login.php?error=' . urlencode('Metodo non consentito.'));
    exit;
}

if (!isset($_POST['email'], $_POST['password'])) {
    header('Location: ../../login.php?error=' . urlencode('Compila tutti i campi obbligatori.'));
    exit;
}

try {
    $authService = new AuthService();
    $authService->login($_POST['email'], $_POST['password']);
    header('Location: ../../index.php');
    exit;
} catch (Throwable $e) {
    header('Location: ../../login.php?error=' . urlencode($e->getMessage()));
    exit;
}
