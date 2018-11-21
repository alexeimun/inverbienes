<?php

namespace Bienes\Repositories;

use Bienes\Misc\Enums\InterestState;
use Bienes\Misc\Enums\MortgageState;
use Bienes\Models\Creditor;
use Bienes\Models\Debtor;
use Bienes\Models\Immovable;
use Bienes\Models\Mortgage;
use Carbon\Carbon;

class CommonRepository extends Repository {

    /**
     * @var Debtor
     */
    private $debtor;
    /**
     * @var Creditor
     */
    private $creditor;
    /**
     * @var Mortgage
     */
    private $mortgage;
    /**
     * @var Immovable
     */
    private $immovable;
    /**
     * @var MortgageRepository
     */
    private $mortgageRepository;

    /**
     * Create a new repository instance.
     *
     * @param Debtor $debtor
     * @param Creditor $creditor
     * @param Mortgage $mortgage
     * @param Immovable $immovable
     * @param MortgageRepository $mortgageRepository
     */
    public function __construct(Debtor $debtor,
        Creditor $creditor,
        Mortgage $mortgage,
        Immovable $immovable,
        MortgageRepository $mortgageRepository) {
        $this->debtor = $debtor;
        $this->creditor = $creditor;
        $this->mortgage = $mortgage;
        $this->immovable = $immovable;
        $this->mortgageRepository = $mortgageRepository;
    }

    public function getDashboard() {
        $dashboard = new \stdClass;
        $dashboard->debtor = $this->debtor->count();
        $dashboard->creditor = $this->creditor->count();
        $dashboard->mortgage = $this->mortgage->count();
        $dashboard->immovable = $this->immovable->count();
        return $dashboard;
    }

    public function nextToPay() {
        $list = new \stdClass;

        $list->mortgages = $this->mortgage->whereDate('final_date', '<=', Carbon::now()->addDays(5))
            ->select(['id', 'debtor_id', 'creditor_id', 'immovable_id', 'final_date', 'start_date'])
            ->with([
                'immovable:id,registration',
                'debtor:id,name', 'creditor:id,name'
            ])->get();

        $list->interests = $this->mortgage->where('state', MortgageState::Valid)->get()->map(function (Mortgage $mortgage) {
            return collect($this->mortgageRepository->getInterests($mortgage->id))->filter(function ($int) {
                return Carbon::now()->addDays(5)->greaterThanOrEqualTo($int['from_date']) &&
                    $int['state'] != InterestState::Paid;
            })->values()->map(function ($i) use ($mortgage) {
                $i['debtor'] = $mortgage->debtor->name;
                $i['mortgage_id'] = $mortgage->id;
                return $i;
            })->last();
        })->filter(function ($v) {
            return count($v);
        })->values();
        return $list;
    }

}

