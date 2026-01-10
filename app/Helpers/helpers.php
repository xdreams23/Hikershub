<?php

use Carbon\Carbon;
// 1. IMPORT CLOUDINARY (WAJIB ADA)
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

if (!function_exists('formatRupiah')) {
    /**
     * Format number to Rupiah currency
     */
    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('formatDate')) {
    /**
     * Format date to Indonesian format
     */
    function formatDate($date, $format = 'd F Y')
    {
        Carbon::setLocale('id');
        return Carbon::parse($date)->translatedFormat($format);
    }
}

if (!function_exists('formatDateTime')) {
    /**
     * Format datetime to Indonesian format
     */
    function formatDateTime($datetime, $format = 'd F Y H:i')
    {
        Carbon::setLocale('id');
        return Carbon::parse($datetime)->translatedFormat($format);
    }
}

if (!function_exists('diffForHumans')) {
    /**
     * Get human readable time difference
     */
    function diffForHumans($date)
    {
        Carbon::setLocale('id');
        return Carbon::parse($date)->diffForHumans();
    }
}

if (!function_exists('uploadImage')) {
    /**
     * Upload image to Cloudinary and return URL
     */
    function uploadImage($file, $folder = 'images')
    {
        if ($file) {
            // 2. LOGIKA BARU: UPLOAD KE CLOUDINARY
            // Ini akan mengirim file ke server Cloudinary dan mengembalikan Link HTTPS
            $result = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder
            ]);
            
            return $result->getSecurePath();
        }
        return null;
    }
}

if (!function_exists('deleteImage')) {
    /**
     * Delete image from storage
     * (Note: Untuk Cloudinary, fitur delete butuh Public ID. 
     * Fungsi ini sementara dibiarkan untuk file lokal lama)
     */
    function deleteImage($path)
    {
        if ($path && \Storage::disk('public')->exists($path)) {
            return \Storage::disk('public')->delete($path);
        }
        return false;
    }
}

if (!function_exists('getBookingStatus')) {
    /**
     * Get booking status color and text
     */
    function getBookingStatus($status)
    {
        return match($status) {
            'pending' => ['color' => 'warning', 'text' => 'Menunggu Pembayaran'],
            'confirmed' => ['color' => 'info', 'text' => 'Dikonfirmasi'],
            'paid' => ['color' => 'success', 'text' => 'Lunas'],
            'cancelled' => ['color' => 'danger', 'text' => 'Dibatalkan'],
            default => ['color' => 'secondary', 'text' => 'Unknown'],
        };
    }
}

if (!function_exists('getDifficultyColor')) {
    /**
     * Get difficulty level color
     */
    function getDifficultyColor($level)
    {
        return match($level) {
            'easy' => 'success',
            'medium' => 'info',
            'hard' => 'warning',
            'extreme' => 'danger',
            default => 'secondary',
        };
    }
}

if (!function_exists('generateStars')) {
    /**
     * Generate star rating HTML
     */
    function generateStars($rating)
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $rating 
                ? '<i class="fas fa-star text-warning"></i>' 
                : '<i class="far fa-star text-muted"></i>';
        }
        return $html;
    }
}