<?php

declare(strict_types=1);

namespace ElephantKiss\Core\Service;

use Magento\Framework\Logger\Handler\Base;
use ElephantKiss\Core\Api\LoggerInterface;
use Magento\Framework\ObjectManagerInterface;

/**
 * Writes log message in var/log/folderName/fileName.log
 */
class Logger implements LoggerInterface
{
    private const DEFAULT_LOG_FILE_NAME = 'elephant_kiss';

    /** @var array */
    private array $loggers = [];
    private ObjectManagerInterface $objectManager;

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * @param string $message
     * @param string $fileName
     * @param string $folderName
     * @return void
     */
    public function execute(string $message, string $fileName = self::DEFAULT_LOG_FILE_NAME, string $folderName = ''): void
    {
        if (strpos($fileName, '.log') === false) {
            $fileName .= '.log';
        }
        $path = ['var', 'log'];
        if (!empty($folderName)) {
            $path[] = $folderName;
        }
        $path[] = $fileName;
        $fileName = implode('/', $path);
        $name = implode('_', $path);
        if (!isset($this->loggers[$name])) {
            $handler = $this->objectManager->create(Base::class, ['fileName' => $fileName]);
            $this->loggers[$name] = $this->objectManager->create(
                \ElephantKiss\Core\Model\Logger::class,
                [
                    'enabled' => 1,
                    'name' => $name,
                    'handlers' => ['system' => $handler],
                ]
            );
        }
        $logger = $this->loggers[$name];
        $logger->info($message);
    }
}
