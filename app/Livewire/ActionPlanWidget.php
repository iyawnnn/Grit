<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MatchReport;
use App\Services\GritActionPlanService;
use Exception;

class ActionPlanWidget extends Component
{
    public MatchReport $matchReport;
    public bool $isLoading = false;
    public ?string $errorMessage = null;

    public function generatePlan(GritActionPlanService $service)
    {
        $this->isLoading = true;
        $this->errorMessage = null;

        try {
            $service->generatePlan($this->matchReport);
            $this->matchReport->refresh();
        } catch (Exception $e) {
            $this->errorMessage = "We could not generate the plan right now. Please try again later.";
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.action-plan-widget');
    }
}