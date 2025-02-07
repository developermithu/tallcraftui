<?php

namespace Developermithu\Tallcraftui\Traits;

use Livewire\Attributes\Url;
use Livewire\WithPagination;

trait WithTcTable
{
    use WithPagination;

    #[Url(as: 'query')]
    public ?string $tcSearch = null;

    public int $tcPerPage = 10;

    #[Url(as: 'sortCol')]
    public ?string $sortCol = null;

    #[Url(as: 'sortAsc')]
    public bool $sortAsc = false;

    public function mountWithTcTable()
    {
        // Retrieve the per-page count from session or use the default
        $this->tcPerPage = session()->get('tcPerPage', $this->tcPerPage);
    }

    public function updated(string $propertyName)
    {
        if (in_array($propertyName, ['tcSearch', 'tcPerPage'])) {
            $this->resetPage();

            // Save the current per-page count in the session
            if ($propertyName === 'tcPerPage') {
                session()->put('tcPerPage', $this->tcPerPage);
            }
        }
    }

    public function sortBy(string $column)
    {
        if ($this->sortCol === $column) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortCol = $column;
            $this->sortAsc = false;
        }
    }

    public function tcApplySorting($query)
    {
        return $query->when($this->sortCol, function ($query) {
            // Handle Relationships Sorting
            if (str_contains($this->sortCol, '.')) {
                [$relation, $column] = explode('.', $this->sortCol);

                return $query->withAggregate($relation, $column)
                    ->orderBy("{$relation}_{$column}", $this->sortAsc ? 'asc' : 'desc');
            }

            // Default column sorting
            return $query->orderBy($this->sortCol, $this->sortAsc ? 'asc' : 'desc');
        });
    }

    public function resetProperty()
    {
        $this->tcSearch = null;
        $this->sortCol = null;
        $this->sortAsc = false;
    }

    public function clearSearch()
    {
        $this->tcSearch = null;
    }
}
