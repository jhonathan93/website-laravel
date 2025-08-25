<?php

namespace App\Services\Image;

use Imagick;
use ImagickException;
use Illuminate\Support\Facades\Crypt;

class ImageService {

    /**
     * @param string $imagePath
     * @param string $userUuid
     * @param string $ip
     *
     * @return bool
     */
    function embedDigitalWatermark(string $imagePath, string $userUuid, string $ip): bool {
        try {
            $image = new Imagick($imagePath);

            $encryptedData = Crypt::encryptString(json_encode([
                'i' => $userUuid,
                's' => config('app.url'),
                'p' => $ip,
                'd' => now()->toIso8601String(),
                'h' => hash_hmac('sha256', $userUuid, config('app.key'))
            ]));

            $image->setImageProperty('comment', $encryptedData);

            if (strtolower($image->getImageFormat()) === 'png') $image->setOption('png:exclude-chunk', 'all');

            $success = $image->writeImage($imagePath);
            $image->clear();

            return $success;
        } catch (ImagickException $e) {
            return false;
        }
    }
}
