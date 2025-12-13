<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialUserApplicationsTable.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 12/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of SpecialUserApplicationsTable component with pagination and search functionality. |
 */


namespace App\Livewire\Parking;

use App\Models\SpecialUserApplication;
use Livewire\Component;
use Livewire\WithPagination;

class SpecialUserApplicationsTable extends Component
{
    use WithPagination;

    public $search = '';

    /**
     * Reset pagination when the search term is updated
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Render the component view with filtered and paginated applications
     */
    public function render()
    {
        $cleanSearch = preg_replace('/[^0-9]/', '', $this->search);

        $query = SpecialUserApplication::query()
            ->with(['user', 'specialParkingRole']);

        if ($cleanSearch) {
            $query->whereHas('user', function ($q) use ($cleanSearch) {
                $q->where('phone_number', 'like', $cleanSearch . '%');
            });
        }

        $applications = $query->paginate(10);

        return view('livewire.parking.special-user-applications-table', [
            'applications' => $applications
        ]);
    }
}
