<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

class AuthService
{
    private UserRepository $userRepository;

    public function __construct(?UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
    }

    public function register(string $nome, string $cognome, string $email, string $password): User
    {
        if ($this->userRepository->findByEmail($email) !== null) {
            throw new RuntimeException('Email già registrata.');
        }

        $user = new User(null, $nome, $cognome, $email, password_hash($password, PASSWORD_DEFAULT));
        $userId = $this->userRepository->create($user);

        $createdUser = $this->userRepository->findById($userId);
        if ($createdUser === null) {
            throw new RuntimeException('Utente creato ma non trovato nel database.');
        }

        return $createdUser;
    }

    public function login(string $email, string $password): User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            throw new RuntimeException('Credenziali non valide.');
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new RuntimeException('Credenziali non valide.');
        }

        return $user;
    }
}
