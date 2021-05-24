<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    const PROFESSION_EMPLOYED = 0;
    const PROFESSION_STUDENT = 1;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '*',
    ];
    public function scopeFilterParticipant($query, $request){

        if(!empty($request->name)){
          $query->where('name', 'like',  trim($request->name).'%' );
        }
        
        if(!empty($request->locality)){
            $query->where('locality', 'like', trim($request->locality).'%' );
          }
        return $query;
    }
}
