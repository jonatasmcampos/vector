<?php

namespace App\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class YajraQueryBuilder extends Builder
{
    private array $rejected_columns;
    private array $columns_and_values;
    private array $date_columns;

    public function __construct(Builder $query)
    {
        parent::__construct($query->getQuery());
        $this->setModel($query->getModel());
        $this->rejected_columns = [];
        $this->columns_and_values = [];
        $this->date_columns = [];
    }

    public function rejectColumns(array $rejected): self{
        $this->rejected_columns = $rejected;
        return $this;
    }

    private function setColumnsAndValues(array $params): void{
        $this->columns_and_values = $params;
    }

    public function setDateColumns(array $dates): self{
        $this->date_columns = $dates;
        return $this;
    }

        private function getColumnsNames(): array{
        return collect($this->columns_and_values)
            ->filter(fn ($element) => is_array($element) && isset($element['column']))
            ->map(fn($element) => $element['column'])
            ->toArray();
    }

    private function validateGlobalSearch(): bool{
        $search = $this->columns_and_values['search'] ?? null;
        if (!$search) {
            return false;
        }
        return true;
    }

    private function removeRejectedColumns(): array{
        $columns = collect($this->columns_and_values)->reject(fn($element) => 
            isset($element['column']) &&
            in_array(($element['column']), $this->rejected_columns, true)
        )
        ->all();
        
        return $columns;
    }

    public function apply(array $params): self
    {
        $this->setColumnsAndValues($params);

        $this->applyGlobalSearch();

        $this->applyColumnFilters();

        return $this;
    }

    protected function applyGlobalSearch(): void {

        if(!$this->validateGlobalSearch()){
            return;
        }

        $columns = $this->removeRejectedColumns();

        $terms = explode(' ', $columns['search']);

        $columns_names = $this->getColumnsNames();
        
        $this->where(function ($query) use ($terms, $columns_names) {
            foreach ($terms as $term) {
                foreach ($columns_names as $column_name) {                 
                    $this->applyWhere(
                        $query,
                        $column_name,
                        $term,
                        'or'
                    );
                }
            }

            $this->applyGlobalDateSearch($query);            
        });
        
    }

    private function applyGlobalDateSearch($query){
        $parsed = $this->parseDateSearch($this->columns_and_values['search']);            
        if ($parsed) {
            foreach ($this->date_columns as $column) {                        
                $this->applyDateWhere(
                    $query,
                    $column,
                    $parsed,
                    'or'
                );                    
            }                
        }
    }

    protected function applyColumnFilters(): void
    {
        $columns = $this->removeRejectedColumns();
        
        foreach ($columns as $column_and_value) {
            $field = $column_and_value['column'] ?? null;
            $value = $column_and_value['value'] ?? null;

            if (!$field || $value === '') {
                continue;
            }

            $this->applyWhere($this, $field, $value);
        }

        $this->applyDateSearch();
    }

    public function applyDateSearch(): self
    {
        foreach ($this->date_columns as $col) {
            $column_and_value = collect($this->columns_and_values)->filter(function($column_and_value) use($col){
                return isset($column_and_value['column']) && $column_and_value['column'] === $col;
            })
            ->values()
            ->first();
            
            $parsed = $this->parseDateSearch($column_and_value['value']);
            if ($parsed) {
                $this->applyDateWhere(
                    $this,
                    $column_and_value['column'],
                    $parsed
                );
            }
        }

        return $this;
    }

    protected function parseDateSearch(string $value): ?string
    {
        $value = trim($value, '/');
        $parts = array_reverse(explode('/', $value));

        if((count($parts) === 1) && ($parts[0])){

        }

        $db_date = "";
        foreach($parts as $part){
            if(!empty($part)){
                $db_date = $db_date . '-' . $part;
            }
        }
        
        if(empty($db_date)){
            return null;
        }
        
        if(count(explode('-', $db_date)) > 3){
            return trim($db_date, '-');
        }

        return $db_date;
    }

    protected function applyDateWhere(
        $query,
        string $column,
        string $parsed,
        string $boolean = 'and'
    ): void {
        
        $boolean === 'or'
            ? $query->orWhere($column, 'like', "%{$parsed}%")
            : $query->where($column, 'like', "%{$parsed}%");
    }

    protected function applyWhere($query, string $field, string $value, string $boolean = 'and'): void
    {
        if (str_contains($field, '.')) {
            [$relation, $column] = $this->splitRelation($field);

            if ($boolean === 'or') {
                $query->orWhereHas($relation, fn ($q) =>
                    $q->where($column, 'like', "%{$value}%")
                );
                return;
            }

            $query->whereHas($relation, fn ($q) =>
                $q->where($column, 'like', "%{$value}%")
            );
            return;
        }

        $boolean === 'or'
            ? $query->orWhere($field, 'like', "%{$value}%")
            : $query->where($field, 'like', "%{$value}%");
    }

    protected function splitRelation(string $field): array
    {
        $parts = explode('.', $field);
        $column = array_pop($parts);

        return [implode('.', $parts), $column];
    }

    public function toDataTable(array $rawColumns = [], ?callable $callback = null)
    {
        $table = DataTables::eloquent($this);

        if ($callback) {
            $table = $callback($table);
        }

        if (!empty($rawColumns)) {
            $table->rawColumns($rawColumns);
        }

        return $table->make(true);
    }
}
