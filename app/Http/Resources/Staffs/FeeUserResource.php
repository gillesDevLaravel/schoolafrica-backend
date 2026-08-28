<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\Admin\SchoolYearResource;
use App\Http\Resources\AdminSimp\SchoolSimpResource;
use App\Http\Resources\ScanReceiptResource;
use App\Http\Resources\StaffsSimp\FeeSimpResource;
use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use App\Models\AcademicYear;
use App\Models\Fee;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'advancePayment' => $this->advancePayment,
            'balancePayment' => $this->balancePayment,
            'payment_mode' => $this->payment_mode,
            'solvable' => $this->solvable,
            'receiptNumber' => $this->receiptNumber,
            'operator' => $this->operator,
            'paymentDate' => $this->paymentDate,
            'photo' => $this->photo,
            'fee' => new FeeSimpResource(Fee::find($this->idFee)),
            'student' => new InscriptionSimpResource(User::withoutGlobalScope('isDeleted')->find($this->idStudent)),
            'school' => new SchoolSimpResource(School::find($this->idSchool)),
            'idSection' => $this->idSection,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
            'telephone' => $this->telephone,
            'reference' => $this->reference,
            'scanReceipt' => $this->scanReceipt,
            "remainingFees" => $this->remainingFees,
            "transaction" => $this->transaction,
            "academicYear" => SchoolYearResource::make(AcademicYear::getCurrent())
        ];
    }
}
