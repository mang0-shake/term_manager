<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColumnResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'htmlId' => $this->html_id,
            'sortable' => $this->sortable,
            'filterable' => $this->filterable,
            'elementType' => $this->element_type,
            'mandatory' => $this->mandatory,
            'position' => (int) $this->position,
            'dropdownOptions' => DropdownOptionsResource::collection($this->dropdownOption),
        ];
    }
}
