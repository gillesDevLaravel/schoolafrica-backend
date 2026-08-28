<?php

namespace App\Rules;

use App\Models\Tranche;
use Illuminate\Contracts\Validation\Rule;

class TrancheBelongsToClasseViaPension implements Rule
{
    protected $idClasse;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($idClasse)
    {
        $this->idClasse = $idClasse;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tranches = Tranche::join('pensions', 'tranches.idPension', '=', 'pensions.id')
            ->join('classes', 'pensions.idLevel', '=', 'classes.idLevel')
            ->where('classes.id', $this->idClasse)
            ->select('tranches.id')
            ->get()
            ->pluck('id')
            ->toArray();

        return in_array($value, $tranches);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "La tranche sélectionnée n'appartient pas à cette classe";
    }
}
