<?php

namespace Vcian\Pulse\PulseMysqlDBAuditor\Livewire;

use Illuminate\Support\Facades\View;
use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;
use Vcian\LaravelDBAuditor\Constants\Constant;
use Vcian\LaravelDBAuditor\Traits\Rules;
use Vcian\LaravelDBAuditor\Traits\Audit;

class PulseMysqlDBAuditor extends Card
{
    use Rules, Audit;

    #[Lazy]
    public function render()
    {
        $constraintDetails = [];

        $standardCheck = array_filter($this->tablesRule(), function ($item) {
            return empty($item['status']);
        });

        $totalTables = count($this->getTableList());
        $successTables = $totalTables - count($standardCheck);
        
        $summary = ['database_name' => $this->getDatabaseName(),
                    'size' => $this->getDatabaseSize(),
                    'table_count' => count($this->getTableList()),
                    'engin' => $this->getDatabaseEngin(),
                    'character_set' => $this->getCharacterSetName()];
        
        $tableList = $this->getTableList();
        $collection = collect(array_values($standardCheck));
        
        foreach($tableList as $table) {
            $primaryField = $this->getConstraintField($table, Constant::CONSTRAINT_PRIMARY_KEY);
            $uniqueField = $this->getConstraintField($table, Constant::CONSTRAINT_UNIQUE_KEY);
            $foreignField = $this->getConstraintField($table, Constant::CONSTRAINT_FOREIGN_KEY);
            $indexField = $this->getConstraintField($table, Constant::CONSTRAINT_INDEX_KEY);

            $constraintDetails[$table] = [
                "primary_key_count" =>  count($primaryField),
                "unique_key_count" => count($uniqueField),
                'foreign_key_count' => count($foreignField),
                "index_key_count" => count($indexField),
                "standardResult" => $collection
            ];
        }
        
        return View::make('pulse_db_auditor::livewire.pulse_db_auditor', [
            'standardCheck' => $standardCheck,
            'summary' => $summary,
            'constraintDetails' => $constraintDetails,
            'total_failed_tables' => count($standardCheck),
            'total_success_tables' => $successTables,
            'total_tables' => $totalTables
        ]);
    }
}
