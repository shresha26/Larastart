<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
'id' => $this->id,
            'from_account' => $this->senderUser->name,
            'from_account_id' => $this->from_account,
            'to_account' => $this->receiverUser->name,
            'to_account_id' => $this->to_account,
            'remarks' => $this->remarks,
            'status' => $this->status,
            'amount' => $this->amount,
            'type' =>  $this->type,
        ];
    }
}
