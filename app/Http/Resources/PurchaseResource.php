<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'items' => PurchaseItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
