<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $manipulated_name = ucwords(strtolower(trim($this->name)));
        $date = date_create($this->dob);
        $dob = date_format($date, "d M Y");

        return [
            'id' => $this->id,
            'name' => $manipulated_name,
            'age' => $this->age,
            'dob' => $dob,
            'profession' => $this->profession == 0 ? 'Employed' : 'Student',
            'locality' => $this->locality,
            'no_of_guests' => $this->no_of_guests,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
