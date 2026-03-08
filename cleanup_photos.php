<?php

/**
 * Cron-скрипт для очистки старых фотографий
 * Запускать раз в сутки: 0 3 * * * php /path/to/cleanup_photos.php
 *
 * Удаляет файлы старше 24 часов из папки uploads/photos
 */

// Путь к папке с фотографиями (измените на свой путь)
$uploadDir = __DIR__ . '/public/uploads/photos/';

// Максимальный возраст файла в секундах (24 часа)
$maxAge = 24 * 60 * 60;

// Разрешённые расширения для удаления
$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'heic', 'heif'];

// Логирование
$logFile = __DIR__ . '/logs/cleanup_photos.log';
$logDir = dirname($logFile);
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

function writeLog($message, $logFile) {
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[{$timestamp}] {$message}\n", FILE_APPEND);
}

// Начало очистки
writeLog("=== Начало очистки фотографий ===", $logFile);

if (!is_dir($uploadDir)) {
    writeLog("ОШИБКА: Папка не существует: {$uploadDir}", $logFile);
    exit(1);
}

$now = time();
$deletedCount = 0;
$errorCount = 0;
$totalSize = 0;

// Сканируем папку
$files = scandir($uploadDir);

foreach ($files as $file) {
    // Пропускаем служебные файлы
    if ($file === '.' || $file === '..' || $file === '.htaccess' || $file === '.gitkeep') {
        continue;
    }

    $filePath = $uploadDir . $file;

    // Пропускаем директории
    if (is_dir($filePath)) {
        continue;
    }

    // Проверяем расширение
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions)) {
        continue;
    }

    // Проверяем возраст файла
    $fileAge = $now - filemtime($filePath);

    if ($fileAge > $maxAge) {
        $fileSize = filesize($filePath);

        if (@unlink($filePath)) {
            $deletedCount++;
            $totalSize += $fileSize;
            writeLog("Удалён: {$file} (возраст: " . round($fileAge / 3600, 1) . " ч, размер: " . round($fileSize / 1024, 1) . " KB)", $logFile);
        } else {
            $errorCount++;
            writeLog("ОШИБКА удаления: {$file}", $logFile);
        }
    }
}

// Итоги
$totalSizeMB = round($totalSize / (1024 * 1024), 2);
writeLog("=== Итого: удалено {$deletedCount} файлов ({$totalSizeMB} MB), ошибок: {$errorCount} ===", $logFile);

// Вывод для консоли
echo "Очистка завершена: удалено {$deletedCount} файлов ({$totalSizeMB} MB), ошибок: {$errorCount}\n";