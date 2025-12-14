<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ActiveScansTable.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 12/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of ActiveScansTable component with pagination and search functionality |
 * 
 */


namespace App\Livewire\Parking;

use App\Models\ActiveUserQrScan;
use Livewire\Component;
use Livewire\WithPagination;

class ActiveScansTable extends Component
{
    use WithPagination;

    public $search = '';

    /**
     * Reset pagination when the search term is updated.
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Render the component view with active user QR scans.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $cleanSearch = preg_replace('/[^0-9]/', '', $this->search);
        $query = ActiveUserQrScan::query()
            ->with(['user', 'parkingEntry']);

        if ($cleanSearch) {
            $query->whereHas('user', function ($q) use ($cleanSearch) {
                $q->where('phone_number', 'like', $cleanSearch . '%');
            });
        }

        $activeEntries = $query->paginate(10);

        return view('livewire.parking.active-scans-table', [
            'activeEntries' => $activeEntries
        ]);
    }
}
