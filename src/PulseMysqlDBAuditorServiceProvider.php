<?php

namespace Vcian\Pulse\PulseMysqlDBAuditor;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Livewire\LivewireManager;
use Vcian\Pulse\PulseMysqlDBAuditor\Livewire\PulseMysqlDBAuditor;

class PulseMysqlDBAuditorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'pulse_db_auditor');

        $this->callAfterResolving('livewire', function (LivewireManager $livewire, Application $app) {
            $livewire->component('pulse_db_auditor', PulseMysqlDBAuditor::class);
        });
    }
}
