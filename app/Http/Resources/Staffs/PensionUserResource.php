<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\Admin\BourseResource;
use App\Http\Resources\Admin\SchoolYearResource;
use App\Http\Resources\AdminSimp\SchoolSimpResource;
use App\Http\Resources\ScanReceiptResource;
use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use App\Http\Resources\StaffsSimp\TrancheSimpResource;
use App\Models\AcademicYear;
use App\Models\Bourse;
use App\Models\School;
use App\Models\Tranche;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PensionUserResource extends JsonResource
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
            'tranche' => new TrancheSimpResource(Tranche::find($this->idTranche)),
            'scanReceipt' => $this->scanReceipt,
            'idPension' => $this->idPension,
            'student' => new InscriptionSimpResource(User::withoutGlobalScope('isDeleted')->find($this->idStudent)),
            'school' => new SchoolSimpResource(School::find($this->idSchool)),
            'photo' => @$this->photo,
            'idSection' => $this->idSection,
            'bourse' => BourseResource::make(Bourse::find($this->idBourse)),
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
            'telephone' => $this->telephone,
            'reference' => $this->reference,
            'transaction' => $this->transaction,
            "remainingPension" => $this->remainingPension,
            "academicYear" => SchoolYearResource::make(AcademicYear::getCurrent())
        ];
    }
}
