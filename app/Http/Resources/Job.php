<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class Job extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
     //   dd($this['job']);
        return [
            'id'         => $this['job']['id'],
            'title'      => $this['job']['objective'],
            'name'       => $this['job']['organizations'][0]['name'],
            'picture'    => $this['job']['organizations'][0]['picture'],
            'team'       => $this->removeMemberKeys($this['detail']['members']),
            'cover'      => $this['detail']['attachments'][0]['address'],
            'slug'      => $this['detail']['slug'],
        ];
    }

    private function removeMemberKeys($membersArray)
    {
        $team = [];
        // dd($membersArray);
        foreach ($membersArray as $i => $member) {
            $person = $member['person'];
            Arr::forget($person, 'id');
            Arr::forget($person, 'hasEmail');
            Arr::forget($person, 'hasBio');
            Arr::forget($person, 'bioCompletion');
            Arr::forget($person, 'weight');
            Arr::forget($person, 'verified');
            $team[] = $person;
        }
        return $team;
    }
}
