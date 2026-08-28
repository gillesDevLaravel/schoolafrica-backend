<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\SchoolSimpResource;
use App\Http\Resources\StaffsSimp\CustomerSimpResource;
use App\Http\Resources\TypeInvoiceResource;
use App\Models\Customer;
use App\Models\School;
use App\Models\TypeInvoice;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'amount' => $this->amount,
            'reasons' => $this->reasons,
            'purchase_order_id' => $this->purchase_order_id,
            'date' => $this->date ? \Carbon\Carbon::parse($this->date)->format('Y-m-d') : null,
            'image' => $this->image,
            'typeUser' => ($this->invoiceable_type == "App\Models\User")
                ? "user"
                : "customer",
            'user' => ($this->invoiceable_type == "App\Models\User")
                ? UserAllResource::make(User::find($this->invoiceable_id))
                : CustomerSimpResource::make(Customer::find($this->invoiceable_id)),
            'idSchool' => $this->idSchool,
            'statut' => $this->statut,
            'mode' => $this->mode,
            'number' => $this->number,
            'type_produit' => $this->type_produit,
            'quantite' => $this->quantite,
            'prix_unitaire' => $this->prix_unitaire,
            'idSection' => $this->idSection,
            'created_at' => $this->created_at,
            'payment_deadline' => $this->payment_deadline,
            'school' => new SchoolSimpResource(School::find($this->idSchool)),
            'typeInvoice' => new TypeInvoiceResource(TypeInvoice::find($this->idTypeInvoice)),
            'product' => new ProductResource($this->product),            
           'salary_components_grouped' => $this->salaryComponents->groupBy('code')->map(function ($components, $code) {
                return [
                    'code' => $code,
                    'components' => $components->sortBy('order')->values()->map(function ($component) {
                        return [
                            'id' => $component->id,
                            'name' => $component->name,
                            'code' => $component->code,
                            'type' => $component->type,
                            'base_amount' => $component->pivot->base_amount,
                            'coef' => $component->pivot->coef,
                            'coef_patronal' => $component->pivot->coef_patronal,
                            'base_patronal' => $component->pivot->base_patronal,
                            'orders' => $component->order ?? 0,
                            'totalAmountSalary' => $component->pivot->base_amount * $component->pivot->coef,
                            'totalAmountPatronal' => $component->pivot->base_patronal * $component->pivot->coef_patronal,
                        ];
                    })
                ];
            })->values(),
        ];
    }
}
