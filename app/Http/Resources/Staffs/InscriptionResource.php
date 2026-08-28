<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\Admin\BourseResource;
use App\Http\Resources\Admin\BourseSimpResource;
use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\AdminSimp\OptionLevelSimpResource;
use App\Http\Resources\AdminSimp\SchoolSimpResource;
use App\Http\Resources\AdminSimp\SectionSimpResource;
use App\Http\Resources\AnnualDecisionResource;
use App\Models\Bourse;
use App\Models\OptionLevel;
use App\Models\Pension;
use App\Models\Section;
use App\Traits\CheckIfRegistrationFeeIsPaidTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\ClassesResource;
use App\Http\Resources\AdminSimp\LevelSimpResource;
use App\Models\Classes;
use App\Models\Level;

class InscriptionResource extends JsonResource
{
    use CheckIfRegistrationFeeIsPaidTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $key = "bulletin.{$this->annualDecision}";
        $translated = __($key);
        return [
            'id' => $this->id,
            'matricule' => $this->matricule,
            'name' => $this->name,
            'scholar_type' => $this->scholar_type,
            'firstname' => $this->firstname,
            'placeofbirth' => $this->placeofbirth,
            'idBourse' => $this->idBourse,
            'situation' => $this->situation,
            'repeater' => $this->repeater,
            'idRole' => $this->idRole,
            'gender' => $this->gender,
            'nationality' => $this->nationality,
            'phone' => $this->phone,
            'whatsapp_number' => $this->whatsapp_number,
            'codeun' => $this->codeun,
            'codedeux' => $this->codedeux,
            'birthday' => $this->birthday,
            'adresse' => $this->adresse,
            'scholar_level' => $this->scholar_level,
            'level' => new LevelSimpResource(Level::find($this->idLevel)),
            'idOptionLevel' => $this->idOptionLevel,
            'idParent' => $this->idParent,
            'username' => $this->username,
            'password' => $this->password,
            'photo' => $this->photo,
            'observation' => $this->observation,
            'archive' => (bool)$this->deleted,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'section' => SectionSimpResource::make(Section::find($this->idSection)),
            'section_name' => @SectionSimpResource::make(Section::find($this->idSection))->name,
            'bourse' => BourseSimpResource::make(Bourse::find($this->idBourse)),
            'isBourseUsed' => (bool)$this->isBourseUsed,
            'classe' => new  ClassesResource(Classes::find($this->idClasse)),
        //    'idClasse2' => $this->idClasse2,
            'old_classe' => $this->old_classe,
            'classe2' => new  ClassesSimpResource(Classes::find($this->idClasse2)),
            'school' => SchoolSimpResource::make($this->school),
            'matterSelected' => $this->matters()->pluck('matter.id'),
            'optionLevel' => OptionLevelSimpResource::make(OptionLevel::find($this->idOptionLevel)),
            'idPension' => optional(
                Pension::where('idLevel', optional($this->classe)->idLevel)->first()
            )->id,
            'annualDecision' => $translated !== $key ? $translated : $this->annualDecision,
            'registrationPaid' => $this->isRegistrationPaid($this->id),
            // Indique si des frais obligatoires sont encore dus pour cet étudiant
            'fees_required' => $this->hasUnpaidRequiredFees($this->id),
            'annualDecisions' => AnnualDecisionResource::collection(
                $this->annualDecisions()->orderBy('idOptionLevel', 'desc')->get()
            ),
            'niu' => $this->niu,
        ];
    }
}
