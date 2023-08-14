<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Make sure to import the User model

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'team_members', 'team_lead', 'created_by'];

    // Define the relationship with the team lead (User)
    public function teamLead()
    {
        return $this->belongsTo(User::class, 'team_lead'); // Assuming 'team_lead' is the foreign key column
    }
    public function teamMember()
    {
        return $this->belongsTo(User::class, 'team_lead'); // Assuming 'team_lead' is the foreign key column
    }
}

