<?php

namespace App\View\Components;

use App\Models\Branch;
use App\Services\User\BranchService;
use Illuminate\View\Component;

class Footer extends Component
{
    protected BranchService $branchService;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $branchNumber = Branch::count();
        $branches = Branch::limit(config('constants.random_branch_number'))->get()->sortBy('name');
        return view('components.footer', [
            'branches' => $branches,
            'branchesNumber' => $branchNumber - config('constants.random_branch_number'),
        ]);
    }
}
