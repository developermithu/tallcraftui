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

    public function updatedWithTcTable(string $propertyName)
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
        $sortCol = $this->tcSafeSortColumn($query);

        return $query->when($sortCol, function ($query) use ($sortCol) {
            // Handle Relationships Sorting
            if (str_contains($sortCol, '.')) {
                [$relation, $column] = explode('.', $sortCol);

                return $query->withAggregate($relation, $column)
                    ->orderBy("{$relation}_{$column}", $this->sortAsc ? 'asc' : 'desc');
            }

            // Default column sorting
            return $query->orderBy($sortCol, $this->sortAsc ? 'asc' : 'desc');
        });
    }

    /**
     * `sortCol` comes from the URL / client, so only allow known columns.
     * Define `tcSortableColumns(): array` on the component to whitelist them,
     * e.g. ['name', 'created_at', 'author.name'].
     */
    protected function tcSafeSortColumn($query): ?string
    {
        if (! $this->sortCol) {
            return null;
        }

        if (method_exists($this, 'tcSortableColumns')) {
            return in_array($this->sortCol, $this->tcSortableColumns(), true) ? $this->sortCol : null;
        }

        // Without a whitelist, accept only "column" or "relation.column" names
        if (! preg_match('/^[A-Za-z_][A-Za-z0-9_]*(\.[A-Za-z_][A-Za-z0-9_]*)?$/', $this->sortCol)) {
            return null;
        }

        // The relation part is called as a method on the model, so it must be one the app defines
        if (str_contains($this->sortCol, '.')) {
            $model = $query->getModel();
            $relation = strstr($this->sortCol, '.', true);

            if (! method_exists($model, $relation)
                || str_starts_with((new \ReflectionMethod($model, $relation))->getDeclaringClass()->getName(), 'Illuminate\\')) {
                return null;
            }
        }

        trigger_error(
            'TallCraftUI: define tcSortableColumns() on '.static::class.' to whitelist sortable columns. It will be required in TallCraftUI 4.0.',
            E_USER_DEPRECATED
        );

        return $this->sortCol;
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
