<?php

namespace Bienes\Repositories;

use Bienes\Misc\Enums\PaymentType;
use Bienes\Models\Company;
use Bienes\Models\Consecutive;
use Bienes\Models\Invoice;
use Bienes\Models\Mortgage;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class InvoiceRepository extends Repository {

    /**
     * @var Mortgage
     */
    private $mortgage;
    /**
     * @var Consecutive
     */
    private $consecutive;
    /**
     * @var Company
     */
    private $company;

    /**
     * Create a new repository instance.
     *
     * @param Invoice $model
     * @param Mortgage $mortgage
     * @param Company $company
     * @param Consecutive $consecutive
     */
    public function __construct(Invoice $model,
        Mortgage $mortgage,
        Company $company,
        Consecutive $consecutive) {
        $this->model = $model;
        $this->mortgage = $mortgage;
        $this->consecutive = $consecutive;
        $this->company = $company;
    }

    public function find($id, $columns = ['*']) {
        $invoice = parent::find($id);
        $invoice->company = $this->company->first();
        return $invoice;
    }

    /**
     * @param array $data
     * @return int|mixed
     */
    public function save(array $data) {
        $mortgage_id = $data['mortgage_id'];
        $consecutive = $this->getConsecutive();
        $invoice = $this->model->create([
            'consecutive' => $consecutive,
            'mortgage_id' => $mortgage_id,
            'user_id' => $this->getUserId(),
            'pay_type' => $data['pay_type'],
            'total' => $data['total'],
            'bank' => $data['bank'] ?? null,
            'check' => $data['check'] ?? null
        ]);
        $payments = collect($data['payments'])->map(function ($payment) use ($consecutive) {
            $payment['consecutive'] = $consecutive;
            return $payment;
        });
        $invoice->movements()->createMany($payments->toArray());
        $this->mapPayments($mortgage_id, $payments);
        $this->consecutive->increment('invoice');
        $invoice->capital = $this->getCapital($mortgage_id);
        $invoice->save();

        return $invoice->id;
    }

    public function mapPayments($mortgage_id, Collection $payments) {
        $mortgage = $this->mortgage->find($mortgage_id);
        $payments->each(function ($payment) use ($mortgage) {
            if($payment['type'] == PaymentType::Payment) {
                $mortgage->decrement('capital', $payment['value']);
            } else if($payment['type'] == PaymentType::IncreaseCapital) {
                $mortgage->increment('capital', $payment['capital_increase']);
            } else if($payment['type'] == PaymentType::PeriodExtended) {
                $mortgage->final_date = Carbon::parse($mortgage->final_date)->addMonths($payment['period']);
                $mortgage->save();
            }
        });
    }

    private function getCapital($mortgage_id) {
        return $this->mortgage->find($mortgage_id)->capital;
    }

    /**
     * @return int|mixed
     */
    public function getConsecutive() {
        return $this->consecutive->first()->invoice;
    }

    public function all($columns = ['*']) {
        return $this->model->without('movements')->latest()->distinct()->get();
    }

    public function cancelInvoice($id) {
        return $this->model->whereId($id)->update(['cancelled_date' => Carbon::now()]);
    }

}

