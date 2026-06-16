<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository
{
    private mysqli $mysqli;

    public function __construct(?mysqli $mysqli = null)
    {
        $this->mysqli = $mysqli ?? getDatabaseConnection();
    }

    public function create(User $user): int
    {
        $nome = $this->escape($user->getNome());
        $cognome = $this->escape($user->getCognome());
        $email = $this->escape($user->getEmail());
        $password = $this->escape($user->getPassword());

        $sql = "INSERT INTO `user` (`nome`, `cognome`, `email`, `password`) VALUES ('{$nome}', '{$cognome}', '{$email}', '{$password}')";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query INSERT: ' . mysqli_error($this->mysqli));
        }

        $userId = $this->mysqli->insert_id;
        $user->setId($userId);

        return $userId;
    }

    public function findById(int $id): ?User
    {
        $sql = "SELECT `id`, `nome`, `cognome`, `email`, `password` FROM `user` WHERE `id` = {$id} LIMIT 1";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $row = mysqli_fetch_assoc($result) ?: null;

        return $row ? User::fromArray($row) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $email = $this->escape($email);
        $sql = "SELECT `id`, `nome`, `cognome`, `email`, `password` FROM `user` WHERE `email` = '{$email}' LIMIT 1";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $row = mysqli_fetch_assoc($result) ?: null;

        return $row ? User::fromArray($row) : null;
    }

    public function findAll(): array
    {
        $sql = 'SELECT `id`, `nome`, `cognome`, `email`, `password` FROM `user` ORDER BY `id` DESC';
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $users = [];
        foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
            $users[] = User::fromArray($row);
        }

        return $users;
    }

    public function update(User $user): bool
    {
        if ($user->getId() === null) {
            throw new InvalidArgumentException('L\'utente deve avere un id valido per essere aggiornato.');
        }

        $id = (int) $user->getId();
        $nome = $this->escape($user->getNome());
        $cognome = $this->escape($user->getCognome());
        $email = $this->escape($user->getEmail());
        $password = $this->escape($user->getPassword());

        $sql = "UPDATE `user` SET `nome` = '{$nome}', `cognome` = '{$cognome}', `email` = '{$email}', `password` = '{$password}' WHERE `id` = {$id}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query UPDATE: ' . mysqli_error($this->mysqli));
        }

        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM `user` WHERE `id` = {$id}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query DELETE: ' . mysqli_error($this->mysqli));
        }

        return true;
    }

    private function escape(string $value): string
    {
        return mysqli_real_escape_string($this->mysqli, $value);
    }
}
