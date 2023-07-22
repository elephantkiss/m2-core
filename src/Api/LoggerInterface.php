<?php
declare(strict_types=1);

namespace ElephantKiss\Core\Api;

/**
 * Service which helps to log data to file
 * @api
 */
interface LoggerInterface
{
    /**
     * @param string $message
     * @param string $fileName
     * @param string $folderName
     * @return void
     */
    public function execute(string $message, string $fileName, string $folderName): void;
}
