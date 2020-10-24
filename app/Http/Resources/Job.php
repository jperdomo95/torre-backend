<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        dd($this);
        return [
            'id'         => $this->job->id,
            'title'      => $this->job->objective,
            'name'       => $this->job->organizations[0]->name,
            'picture'    => $this->job->organizations[0]->picture,
            'team'       => $this->removeMemberKeys($this->job->members),
            'cover'      => $this->detail->attachments[0]->address,
            'slug'      => $this->detail->slug,
        ];
    }

    private function removeMemberKeys($membersArray)
    {
        foreach ($membersArray as $i => $member) {
            # code...
        }
    }
}
