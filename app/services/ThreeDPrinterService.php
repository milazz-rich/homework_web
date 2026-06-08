<?php

require_once __DIR__ . '/../repositories/ThreeDPrinterRepository.php';

class ThreeDPrinterService
{
    private ThreeDPrinterRepository $printerRepository;

    public function __construct(?ThreeDPrinterRepository $printerRepository = null)
    {
        $this->printerRepository = $printerRepository ?? new ThreeDPrinterRepository();
    }

    /**
     * @return ThreeDPrinter[]
     */
    public function getPrinters(?int $limit = null): array
    {
        return $this->printerRepository->findFirstN($limit);
    }
}
