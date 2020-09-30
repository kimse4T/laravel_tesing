<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Team extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'size'
    ];

    public function add($user)
    {
        $this->guardAgainstTooManyMembers($user);

        $method = $user instanceof User ? 'save':'saveMany';

        $this->members()->$method($user);

    }

    public function remove($user)
    {
        if($user instanceof User){
            return $user->update(['team_id'=>null]);
        }

        $this->members()->whereIn('id',$user->pluck('id'))->update(['team_id'=>null]);


    }

    public function restart()
    {
        $this->members()->update(['team_id'=>null]);
    }

    public function members()
    {
        return $this->hasMany('App\Models\User');
    }

    public function count()
    {
        return $this->members()->count();
    }

    protected function guardAgainstTooManyMembers($users)
    {
        $numUsersToAdd = ($users instanceof User)? 1 : $users->count();

        $newTeamCount = $this->count()+$numUsersToAdd;

        if($newTeamCount>$this->size){
            throw new \Exception();
        }
    }
}
