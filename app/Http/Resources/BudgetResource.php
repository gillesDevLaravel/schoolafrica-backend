<?php

namespace App\Http\Resources;

use App\Enums\BudgetTypeEnum;
use App\Http\Resources\AdminSimp\SchoolSimpResource;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\CashIn;
use App\Models\FeeUser;
use App\Models\Invoice;
use App\Models\Pension;
use App\Models\PensionUser;
use App\Models\TypeInvoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param $request
     * @return string[]
     */
    public function toArray($request)
    {
        $type = $this->type;

        $total_realisation = 0;
        $total_percentage = 0;
        $items_count = 0;

        $typeInvoiceOrRecipeItems = $this->typeInvoiceOrRecipeItems()->map(function ($item) use ($type, &$total_realisation, &$total_percentage, &$items_count) {
            $typeId = $item->id;

            if ($type == BudgetTypeEnum::RECIPE) {
                $pensionIds = Pension::where('type_of_recipe_id', $typeId)->pluck('id');

                $pensions = PensionUser::whereIn('idPension', $pensionIds)->sum('advancePayment');

                $fees = FeeUser::whereHas('fee', function ($q) use ($typeId) {
                    $q->where('type_of_recipe_id', $typeId);
                })->sum('advancePayment');

                $cashins = CashIn::where('type_of_recipe_id', $typeId)->sum('amount_received');

                $total = $pensions + $fees + $cashins;
            } else {
                $total = Invoice::where('idTypeInvoice', $typeId)->sum('amount');
            }

            $subTotal = $item['sub_total_amount'] ?? 0;

            $percentage = $subTotal > 0
                ? round(($total / $subTotal) * 100, 2)
                : 0;

            // Mise à jour des compteurs globaux
            $total_realisation += $total;
            $total_percentage += $percentage;
            $items_count++;

            // Ajout au résultat
            $item['total'] = $total;
            $item['percentage'] = $percentage;

            return $item;
        });

        $percentage_realisation = $items_count > 0
            ? round($total_percentage / $items_count, 2)
            : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'realisation' => $this->realisation,
            'school' => SchoolSimpResource::make($this->school),
            'typeInvoiceOrRecipeItems' => $typeInvoiceOrRecipeItems,
            'total_amount' => $this->total_amount,
            'realisation_amount' => ($this->realisation !== null)
                ? ($this->total_amount * $this->realisation) / 100
                : null,
            'total_realisation' => $total_realisation,
            'percentage_realisation' => ($this->total_amount > 0)
                ? number_format((($total_realisation * 100) / $this->total_amount), 2, '.', '')
                : null,
            'creator' => UserSimpResource::make($this->creator),
            'createdAt' => $this->created_at,
        ];
    }
}
