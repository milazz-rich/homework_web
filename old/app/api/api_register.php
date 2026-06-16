<?php

require_once __DIR__ . '/../services/AuthService.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../register.php?error=' . urlencode('Metodo non consentito.'));
    exit;
}

if (!isset($_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['password'], $_POST['codice_verifica'])) {
    header('Location: ../../register.php?error=' . urlencode('Compila tutti i campi obbligatori.'));
    exit;
}

try {
    $authService = new AuthService();
    $authService->register($_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['password'], $_POST['codice_verifica']);
    header('Location: ../../index.php');
    exit;
} catch (Throwable $e) {
    header('Location: ../../register.php?error=' . urlencode($e->getMessage()));
    exit;
}
