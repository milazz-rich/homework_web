<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/3dprinter.php';

class ThreeDPrinterRepository
{
    private mysqli $mysqli;

    public function __construct(?mysqli $mysqli = null)
    {
        $this->mysqli = $mysqli ?? getDatabaseConnection();
    }

    public function create(ThreeDPrinter $printer): int
    {
        $name = $this->escape($printer->getName());
        $subtitle = $this->escape($printer->getSubtitle());
        $price = (float) $printer->getPrice();
        $imagePath = $this->escape($printer->getImagePath());

        $sql = "INSERT INTO `printer` (`name`, `subtitle`, `price`, `image_path`) VALUES ('{$name}', '{$subtitle}', {$price}, '{$imagePath}')";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query INSERT: ' . mysqli_error($this->mysqli));
        }

        $printerId = $this->mysqli->insert_id;
        $printer->setId($printerId);

        return $printerId;
    }

    public function findById(int $id): ?ThreeDPrinter
    {
        $sql = "SELECT `id`, `name`, `subtitle`, `price`, `image_path` FROM `printer` WHERE `id` = {$id} LIMIT 1";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $row = mysqli_fetch_assoc($result) ?: null;

        return $row ? ThreeDPrinter::fromArray($row) : null;
    }

    /**
     * @return ThreeDPrinter[]
     */
    public function findAll(): array
    {
        $sql = 'SELECT `id`, `name`, `subtitle`, `price`, `image_path` FROM `printer` ORDER BY `id` DESC';
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $printers = [];
        foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
            $printers[] = ThreeDPrinter::fromArray($row);
        }

        return $printers;
    }

    /**
     * @return ThreeDPrinter[]
     */
    public function findFirstN(?int $limit = null): array
    {
        if ($limit === null) {
            return $this->findAll();
        }

        $limit = max(0, $limit);
        $sql = "SELECT `id`, `name`, `subtitle`, `price`, `image_path` FROM `printer` ORDER BY `id` DESC LIMIT {$limit}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $printers = [];
        foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
            $printers[] = ThreeDPrinter::fromArray($row);
        }

        return $printers;
    }

    public function update(ThreeDPrinter $printer): bool
    {
        if ($printer->getId() === null) {
            throw new InvalidArgumentException('La stampante deve avere un id valido per essere aggiornata.');
        }

        $id = (int) $printer->getId();
        $name = $this->escape($printer->getName());
        $subtitle = $this->escape($printer->getSubtitle());
        $price = (float) $printer->getPrice();
        $imagePath = $this->escape($printer->getImagePath());

        $sql = "UPDATE `printer` SET `name` = '{$name}', `subtitle` = '{$subtitle}', `price` = {$price}, `image_path` = '{$imagePath}' WHERE `id` = {$id}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query UPDATE: ' . mysqli_error($this->mysqli));
        }

        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM `printer` WHERE `id` = {$id}";
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
