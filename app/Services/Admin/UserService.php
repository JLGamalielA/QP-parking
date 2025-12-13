<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UserService.php
 * Created on: 03/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 03/12/2025
 *   Modified by: Daniel Yair Mendoza Alvarez
 *   Description: Initial creation. Handles business logic for retrieving users. |
 */

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class UserService
{
    /**
     * Get paginated users with advanced filters and calculated properties.
     *
     * @param string|null $search Phone number to search.
     * @param string|null $platform 'web' or 'mobile'.
     * @param string|null $subscriptionStatus 'active' or 'inactive'.
     * @param int $perPage Pagination limit.
     * @return LengthAwarePaginator
     */
    public function getUsersList(?string $search, ?string $platform, ?string $subscriptionStatus, int $perPage): LengthAwarePaginator
    {
        $query = User::query()
            ->with(['subscription.subscription'])
            ->doesntHave('generalAdmin');

        if (!empty($search)) {
            $query->where('phone_number', 'like', "{$search}%");
        }
        if (!empty($platform) && in_array($platform, ['web', 'mobile'])) {
            $query->where('platform', $platform);
        }
        if (!empty($subscriptionStatus)) {
            $now = Carbon::now();
            if ($subscriptionStatus === 'active') {
                $query->whereHas('subscription', function (Builder $q) use ($now) {
                    $q->where('is_active', 1)->where('end_date', '>=', $now);
                });
            } elseif ($subscriptionStatus === 'inactive') {
                $query->where(function (Builder $q) use ($now) {
                    $q->doesntHave('subscription')
                        ->orWhereHas('subscription', function (Builder $sq) use ($now) {
                            $sq->where('is_active', 0)->orWhere('end_date', '<', $now);
                        });
                });
            }
        }

        $users = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        // 6. Transform Data
        $users->through(function ($user) {
            $sub = $user->subscription;
            // Calculate Plan Name
            $user->displayPlanName = $sub && $sub->subscription ? $sub->subscription->name : 'N/A';
            // Calculate Active Status
            $user->isSubscriptionActive = $sub && $sub->is_active && Carbon::parse($sub->end_date)->isFuture();
            $user->subscriptionEndDate = $sub ? Carbon::parse($sub->end_date)->format('d/m/Y') : null;
            return $user;
        });

        return $users;
    }
}
