<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class BooksCollection extends JsonResource
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
    'status_code' => '200',
    'status' => 'success', 
    'data' => [
    'name' => $this->name, 
    'isbn' => $this->isbn,
    'authors' => array($this->authors),
    'country' => $this->country,
    'number_of_pages' => $this->number_of_pages,
    'publisher' => $this->publisher,
    'release_date' => $this->release_date, 
    ], 
    ];
    }
}
 