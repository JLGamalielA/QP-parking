<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingValidationService.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Service class for complex parking validations (e.g., Geofencing) |
 * 
 */

namespace App\Services\Parking;

use App\Models\Parking;

class ParkingValidationService
{
    /**
     * Validates if a parking location overlaps with existing ones within a radius.
     *
     * @param array $data Input data containing latitude and longitude
     * @param int|null $excludeId ID to exclude from check (for updates)
     * @return array|null Error array or null if valid
     */
    public function validateGeofence(array $data, ?int $excludeId = null): ?array
    {
        if (empty($data['latitude']) || empty($data['longitude'])) {
            return null;
        }

        $lat = (float) $data['latitude'];
        $lng = (float) $data['longitude'];
        $radius = 25;

        // Bounding box calculation for performance optimization
        $degLat = $radius / 111320;
        $degLng = $radius / (111320 * max(0.000001, cos(deg2rad($lat))));

        $query = Parking::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereBetween('latitude', [$lat - $degLat, $lat + $degLat])
            ->whereBetween('longitude', [$lng - $degLng, $lng + $degLng]);

        if ($excludeId) {
            $query->where('parking_id', '!=', $excludeId);
        }

        // Haversine formula check in SQL
        $exists = $query->whereRaw("
            (6371000 * acos(
                least(1, greatest(-1,
                    cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(latitude))
                ))
            )) < ?
        ", [$lat, $lng, $lat, $radius])->exists();

        if ($exists) {
            return ['latitude' => "Ya existe un estacionamiento registrado a menos de {$radius} metros de estas coordenadas."];
        }

        return null;
    }
}
