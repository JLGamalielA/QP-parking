<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SubscriptionService.php
 * Created on: 04/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 04/12/2025
 *   Modified by: Daniel Yair Mendoza Alvarez
 *   Description: SubscriptionService implementation. |
 */

namespace App\Services\Admin;

use App\Models\Subscription;
use App\Models\UserSubscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriptionService
{
    /**
     * Get paginated subscription plans with benefits.
     *
     * @param int $perPage Items per page.
     * @return LengthAwarePaginator
     */
    public function getSubscriptionsList(int $perPage): LengthAwarePaginator
    {
        // 1. Fetch subscriptions with their benefits to avoid N+1 problem
        $query = Subscription::query()->with('benefits');

        // 2. Order by price ascending (logical order for plans)
        $subscriptions = $query->orderBy('price', 'asc')
            ->paginate($perPage);

        // 3. Transform data for presentation
        $subscriptions->through(function ($sub) {
            // Format price with currency symbol
            $sub->formattedPrice = '$' . number_format($sub->price, 2);

            // Format duration label
            $sub->displayDuration = $sub->duration_days . ' días';

            return $sub;
        });

        return $subscriptions;
    }

    /**
     * Find a subscription by its ID or throw 404.
     *
     * @param int $id
     * @return Subscription
     * @throws ModelNotFoundException
     */
    public function getSubscriptionById(int $id): Subscription
    {
        return Subscription::findOrFail($id);
    }

    /**
     * Update specific fields of a subscription.
     * Only allows modification of Name and Price as per business rules.
     *
     * @param Subscription $subscription
     * @param array $data Validated data containing 'name' and 'price'.
     * @return bool
     */
    public function updateSubscription(Subscription $subscription, array $data): bool
    {
        return $subscription->update([
            'name'  => $data['name'],
            'price' => $data['price'],
        ]);
    }

    /**
     * Deactivate a user's active subscription.
     * Sets is_active to false.
     *
     * @param int $userId The ID of the user.
     * @return array Result status and message.
     */
    public function deactivateUserSubscription(int $userId): array
    {
        $userSubscription = UserSubscription::where('user_id', $userId)
            ->where('is_active', true)
            ->first();

        if (!$userSubscription) {
            return [
                'ok' => false,
                'error' => 'El usuario no tiene una suscripción activa para cancelar.'
            ];
        }

        $updated = $userSubscription->update(['is_active' => false]);

        if ($updated) {
            return ['ok' => true, 'message' => 'La suscripción del usuario ha sido desactivada correctamente.'];
        }

        return ['ok' => false, 'error' => 'No se pudo actualizar el estado de la suscripción.'];
    }
}
