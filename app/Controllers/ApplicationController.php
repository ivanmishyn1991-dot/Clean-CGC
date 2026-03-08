<?php

namespace App\Controllers;

use App\Entities\Application;
use App\Services\TelegramSenderService;
use Flight as F;

class ApplicationController extends Controller
{
    private const UPLOAD_DIR = __DIR__ . '/../../public/uploads/photos/';

    public function create(): void
    {
        $data = F::request()->data->getData();

        // Получаем загруженные фото из JSON
        $uploadedPhotos = [];
        if (!empty($data['uploaded_photos'])) {
            $photosData = json_decode($data['uploaded_photos'], true);
            if (is_array($photosData)) {
                $uploadedPhotos = $photosData;
            }
        }

        $application = new Application();
        $application
            ->setName($data['name'] ?? '')
            ->setEmail($data['email'] ?? '')
            ->setPhone($data['phone'] ?? '')
            ->setCity($data['city'] ?? '')
            ->setMessage($data['message'] ?? '')
            ->setContactConsent($data['consent_contact_all'] ?? false);

        // Сохраняем список фото в заявке (если есть такое поле в Entity)
        if (!empty($uploadedPhotos) && method_exists($application, 'setImages')) {
            $application->setImages(json_encode($uploadedPhotos));
        }

        F::em()->persist($application);
        F::em()->flush();

        // Формируем сообщение для Telegram
        $message = $this->view
            ->assign('application', $application)
            ->render('applications/tg_notification.twig');

        $tg = new TelegramSenderService();
        $token = $_ENV['TG_TOKEN'] ?? '';
        $channel = $_ENV['TG_CHANNEL'] ?? '';

        // Отправляем текстовое сообщение
        $tg->send($channel, $message, $token);

        // Отправляем фотографии если есть
        if (!empty($uploadedPhotos)) {
            $photoPaths = [];
            foreach ($uploadedPhotos as $photo) {
                $photoPath = self::UPLOAD_DIR . basename($photo['name']);
                if (file_exists($photoPath)) {
                    $photoPaths[] = $photoPath;
                }
            }

            if (!empty($photoPaths)) {
                // Формируем caption для фото
                $photoCaption = "📷 <b>Фото к заявке #{$application->getId()}</b>\n";
                $photoCaption .= "👤 {$application->getName()}\n";
                $photoCaption .= "📍 {$application->getCity()}";

                // Отправляем фото (одно или группу)
                $tg->sendMediaGroup($channel, $photoPaths, $photoCaption, $token);
            }
        }

        F::json(['success' => true]);
    }

    /**
     * Quick Quote - заявка на обратный звонок
     */
    public function quickQuote(): void
    {
        $data = F::request()->data->getData();
        
        $phone = $data['phone'] ?? '';
        
        if (empty($phone)) {
            F::json(['success' => false, 'error' => 'Phone is required']);
            return;
        }
        
        // Формируем сообщение для Telegram с подписью "заявка на обратный звонок"
        $message = "📞 <b>Заявка на обратный звонок</b>\n\n";
        $message .= "📱 Телефон: <code>{$phone}</code>\n";
        $message .= "🕐 Время: " . date('d.m.Y H:i:s');
        
        $tg = new TelegramSenderService();
        $token = $_ENV['TG_TOKEN'] ?? '';
        $channel = $_ENV['TG_CHANNEL'] ?? '';
        
        // Отправляем в Telegram
        $tg->send($channel, $message, $token);
        
        F::json(['success' => true]);
    }
}
