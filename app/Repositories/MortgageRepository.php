<?php

namespace Bienes\Repositories;

use Bienes\Misc\Enums\InterestState;
use Bienes\Models\Mortgage;
use Carbon\Carbon;

class MortgageRepository extends Repository {

    /**
     * Create a new repository instance.
     *
     * @param Mortgage $model
     */
    public function __construct(Mortgage $model) {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data) {
        $mortgage = parent::save(array_except($data, ['promissory_notes']));
        $m = $this->model->find($mortgage->id);
        $m->update(['initial_balance' => $mortgage->capital]);
        if($data['type'] != 'Cerrada') {
            $m->promissory_notes()->delete();
            $m->promissory_notes()->createMany($data['promissory_notes']);
        }
        return $mortgage;
    }

    public function getPayments($id) {
        return [
            'payments' => $this->model->find($id)->allPayments,
            'interests' => $this->getInterests($id)
        ];
    }

    public function getInterests($id) {
        $mortgage = $this->model->find($id);
        $months = Carbon::parse($mortgage->start_date)->diffInMonths($mortgage->final_date);
        $interests = [];
        $fromDate = $mortgage->start_date;
        $interestPaid = $mortgage->interests()->get()->pluck('month')->toArray();
        for ($i = 1; $i <= $months; $i++) {
            $ind = $i - 1;
            $toDate = Carbon::parse($mortgage->start_date)->addMonthNoOverflow($i)->toDateString();
            $payments = $this->sumPayments($mortgage, $toDate);
            $extended_capital = $this->sumExtendedCapital($mortgage, $toDate);
            $capital_base = $mortgage->initial_balance + $extended_capital - $payments;
            $interests[$ind]['value'] = $capital_base * ($mortgage->interest / 100);
            if(in_array($i, $interestPaid)) {
                $interest = $this->getInterest($mortgage, $i);
                $interests[$ind]['state'] = InterestState::Paid;
                $interests[$ind]['concept'] = $interest->concept;
                $interests[$ind]['value'] = $interest->value;
                $interests[$ind]['consecutive'] = $interest->consecutive;
                $interests[$ind]['invoice_id'] = $interest->invoice_id;
            } else if(Carbon::now()->greaterThan($toDate)) {
                $interests[$ind]['state'] = InterestState::Debt;
            } else {
                $interests[$ind]['state'] = InterestState::NotPaid;
            }

            $interests[$ind]['from_date'] = $fromDate;
            $interests[$ind]['to_date'] = $toDate;
            $fromDate = $toDate;
        }

        return $interests;
    }

    public function getInterest(Mortgage $mortgage, $month) {
        return $mortgage->interests()->where('month', $month)->first();
    }

    public function sumPayments(Mortgage $mortgage, $date) {
        return $mortgage->payments()->whereDate('created_at', '<=', $date)
            ->get()->sum('value');
    }

    public function sumExtendedCapital(Mortgage $mortgage, $date) {
        return $mortgage->extend_capitals()->whereDate('created_at', '<=', $date)
            ->get()->sum('value');
    }

    public function all($columns = ['*']) {
        return $this->model->with('promissory_notes')->get();
    }

    public function transferMortgageDebtor($data) {
        $this->model->find($data['mortgage_id'])->update(['debtor_id' => $data['debtor_id']]);
    }

    public function transferMortgageCreditor($data) {
        $this->model->find($data['mortgage_id'])->update(['creditor_id' => $data['creditor_id']]);
    }

}

