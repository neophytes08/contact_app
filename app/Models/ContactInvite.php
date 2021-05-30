<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInvite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'contact_id',
        'direct_invite',
        'invite_link',
        'status'
    ];
}
