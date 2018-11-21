<?php

namespace Bienes\Repositories;

use Bienes\Misc\Enums\PaymentType;
use Bienes\Models\Creditor;
use Bienes\Models\Debtor;
use Bienes\Models\Invoice;
use Bienes\Models\Mortgage;
use Bienes\Models\Movement;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportRepository extends Repository {

    /**
     * @var Debtor
     */
    private $debtor;
    /**
     * @var MortgageRepository
     */
    private $mortgageRepository;
    /**
     * @var Movement
     */
    private $movement;
    /**
     * @var Creditor
     */
    private $creditor;

    /**
     * Create a new repository instance.
     *
     * @param Invoice $model
     * @param Debtor $debtor
     * @param Creditor $creditor
     * @param Movement $movement
     * @param MortgageRepository $mortgageRepository
     */
    public function __construct(Invoice $model,
        Debtor $debtor,
        Creditor $creditor,
        Movement $movement,
        MortgageRepository $mortgageRepository) {
        $this->model = $model;
        $this->debtor = $debtor;
        $this->mortgageRepository = $mortgageRepository;
        $this->movement = $movement;
        $this->creditor = $creditor;
    }

    public function reportDebtor($id, $from, $to) {
        $debtor = $this->debtor->find($id);
        $report = new \stdClass;
        $report->mortgages = $debtor->mortgages()
            ->with(['movements' => function ($q) use ($from, $to) {
                $q->whereYear('created_at', '>=', $from)
                    ->whereYear('created_at', '<=', $to);
            }, 'immovable' => function ($q) {
                $q->without(['owner', 'city']);
            }])->without('debtor')->get();
        $report->debtor = $debtor->first();
        $this->mapMovements($report->mortgages);
        return $report;
    }

    public function reportCreditor($id, $from, $to) {
        $creditor = $this->creditor->find($id);
        $report = new \stdClass;

        $report->mortgages = $creditor->mortgages()
            ->with(['movements' => function ($q) use ($from, $to) {
                $q->whereYear('created_at', '>=', $from)
                    ->whereYear('created_at', '<=', $to);
                $q->select(['mortgage_id', 'value', 'consecutive', 'concept']);
            }, 'debtor:id,name'])->without(['creditor', 'immovable'])
            ->get(['id', 'creditor_id', 'fee_admin', 'debtor_id']);
        $report->creditor = $creditor->first();
        return $report;
    }

    private function mapMovements(Collection $mortgages) {
        $mortgages->each(function (Mortgage $mortgage) {
            $interests = $this->reduceValue($mortgage, PaymentType::Interest);
            $payments = $this->reduceValue($mortgage, PaymentType::Payment);
            $paids = [];
            $debts = [];
            $m = $this->getInterestsMonth($mortgage);
            if($m['months'] > 0)
                $paids[] = ['type' => PaymentType::Interest, 'up_month' => $m['date'], 'value' => $interests];
            $paids[] = ['type' => PaymentType::Payment, 'concept' => 'Saldo abonado', 'value' => $payments];

            $mortgage->movements->filter(function ($c) {
                return !in_array($c->type, [PaymentType::Payment, PaymentType::Interest]);
            })->map(function (Movement $commission) use (&$paids) {
                array_push($paids, $commission->toArray());
            });

            $debt_interests = collect($this->mortgageRepository->getInterests($mortgage->id))->filter(function ($int) {
                return $int['state'] != 1;
            })->reduce(function ($a, $int) {
                return $int['value'] + $a;
            }, 0);
            $month = Carbon::parse($mortgage->start_date)->addMonthNoOverflow($m['months'] == 0 ? 0 : $m['months'] + 1)->toDateString();
            //Debts
            $debts[] = ['type' => PaymentType::Interest, 'from_month' => $month, 'value' => $debt_interests];
            $debts[] = ['type' => PaymentType::Payment, 'concept' => 'Saldo capital', 'value' => $mortgage->capital];

            $mortgage->paids = $paids;
            $mortgage->debts = $debts;
            unset($mortgage->movements);
        });
    }

    private function reduceValue(Mortgage $mortgage, $type) {
        return $mortgage->movements->reduce(function ($a, Movement $b) use ($type) {
            if($b->type == $type)
                return $b->value + $a;
            return $a;
        }, 0);
    }

    private function getInterestsMonth(Mortgage $mortgage) {
        $months = $mortgage->movements->filter(function (Movement $movement) {
            return $movement->type == PaymentType::Interest;
        })->count();
        return [
            'date' => Carbon::parse($mortgage->start_date)->addMonthNoOverflow($months)->toDateString(),
            'months' => $months
        ];
    }

    public function dailyBlock($date) {
        return $this->movement->with(['mortgage' => function ($q) {
            $q->select(['id', 'fee_admin']);
            $q->without(['immovable', 'creditor', 'debtor']);
        }])->whereIn('type', [PaymentType::Commission, PaymentType::Interest, PaymentType::Payment])
            ->whereDate('created_at', $date)->get(['mortgage_id', 'consecutive', 'type', 'value']);
    }

    public function dailyIncomes($date) {
        return $this->movement->with(['mortgage' => function ($q) {
            $q->select(['id', 'debtor_id', 'creditor_id']);
            $q->without('immovable');
            $q->with(['debtor:id,name', 'creditor:id,name']);
        }])->whereDate('created_at', $date)->get(['value', 'consecutive', 'id', 'mortgage_id']);
    }
}

