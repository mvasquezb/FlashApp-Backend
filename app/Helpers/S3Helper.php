<?php

namespace App\Helpers;

class S3Helper {
    // Hardcoded for now
    public static function getFileUrl($filePath) {
        $urlBase = 'https://s3.us-east-2.amazonaws.com/flashapp-bucket';
        return "$urlBase$filePath";
    }
}
