<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UsersTable.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 12/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of UsersTable component with pagination and search functionality. |
 */


namespace App\Livewire\Admin;

use App\Models\User;
use App\Services\Admin\UserService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $platform = '';
    public $status = '';

    /**
     * Clear all filters and reset pagination
     */
    public function clearFilters()
    {
        $this->reset(['search', 'platform', 'status']);

        $this->resetPage();
    }

    /**
     * Reset pagination when any filter is updated
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when any filter is updated
     */
    public function updatedPlatform()
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when any filter is updated
     */
    public function updatedStatus()
    {
        $this->resetPage();
    }

    /**
     * Render the component view with filtered and paginated users
     */
    public function render(UserService $userService)
    {
        $cleanSearch = preg_replace('/[^0-9]/', '', $this->search);

        $users = $userService->getUsersList(
            $cleanSearch,
            $this->platform,
            $this->status,
            10
        );

        return view('livewire.admin.users-table', [
            'users' => $users
        ]);
    }
}
