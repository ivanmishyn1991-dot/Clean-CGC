<?php

namespace App\Services;

use Flight as F;

class TelegramSenderService
{
    public function send($chatID, $message, $token)
    {
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $data = [
            'chat_id' => $chatID,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return "Ошибка cURL: " . $error;
        }

        return json_decode($response, true);
    }

    /**
     * Отправка фотографии в Telegram
     */
    public function sendPhoto($chatID, $photoPath, $caption, $token)
    {
        $url = "https://api.telegram.org/bot{$token}/sendPhoto";

        // Проверяем существование файла
        if (!file_exists($photoPath)) {
            return ['ok' => false, 'error' => 'File not found: ' . $photoPath];
        }

        $data = [
            'chat_id' => $chatID,
            'photo' => new \CURLFile($photoPath),
            'caption' => $caption,
            'parse_mode' => 'HTML'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['ok' => false, 'error' => "cURL error: " . $error];
        }

        return json_decode($response, true);
    }

    /**
     * Отправка группы фотографий (медиагруппа)
     */
    public function sendMediaGroup($chatID, $photoPaths, $caption, $token)
    {
        if (empty($photoPaths)) {
            return ['ok' => false, 'error' => 'No photos provided'];
        }

        // Если только одно фото - отправляем обычным методом
        if (count($photoPaths) === 1) {
            return $this->sendPhoto($chatID, $photoPaths[0], $caption, $token);
        }

        $url = "https://api.telegram.org/bot{$token}/sendMediaGroup";

        $media = [];
        $files = [];

        foreach ($photoPaths as $index => $photoPath) {
            if (!file_exists($photoPath)) {
                continue;
            }

            $attachName = 'photo' . $index;
            $mediaItem = [
                'type' => 'photo',
                'media' => 'attach://' . $attachName
            ];

            // Добавляем caption только к первому фото
            if ($index === 0 && !empty($caption)) {
                $mediaItem['caption'] = $caption;
                $mediaItem['parse_mode'] = 'HTML';
            }

            $media[] = $mediaItem;
            $files[$attachName] = new \CURLFile($photoPath);
        }

        if (empty($media)) {
            return ['ok' => false, 'error' => 'No valid photos found'];
        }

        $data = [
            'chat_id' => $chatID,
            'media' => json_encode($media)
        ];

        // Добавляем файлы
        $data = array_merge($data, $files);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['ok' => false, 'error' => "cURL error: " . $error];
        }

        return json_decode($response, true);
    }
}
