<?php
namespace App\Services;

use App\Enums\PurchaseOrderPriorityEnum;
use App\Enums\PurchaseOrderStatusEnum;
use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseOrderService
{
    /**
     * Créer un bon d'achat
     *
     * @param array $payload
     * @return PurchaseOrder
     */
    public function createPurchaseOrder(array $payload): PurchaseOrder
    {
        $author = auth()->id();
        return DB::transaction(function () use ($payload, $author) {

            $purchaseOrder = PurchaseOrder::create([
                'reference' => generateReferenceNumber(PurchaseOrder::class, 'reference', 6),
                'supplier_id'   => $payload['supplier_id'],
                'description'   => $payload['description'] ?? null,
                'status'        => $payload['status'] ?? PurchaseOrderStatusEnum::REQUESTING_PRICE,
                'priority'      => $payload['priority'] ?? PurchaseOrderPriorityEnum::LOW,
                'quotation_file'=> $payload['quotation_file'] ?? null,
                'responsible_id'=> $payload['responsible_id'],
                'created_by'    => $author,
            ]);

            if (!empty($payload['articles'])) {
                $articleData = [];

                foreach ($payload['articles'] as $article) {
                    $articleData[$article['id']] = [
                        'unit_price' => $article['unit_price'],
                        'quantity'   => $article['quantity'],
                    ];
                }

                $purchaseOrder->articles()->sync($articleData);
            }

            Log::info("Bon d'achat créé", [
                'purchase_order_id' => $purchaseOrder->id,
                'author'            => $author,
            ]);

            return $purchaseOrder;
        });
    }
}
