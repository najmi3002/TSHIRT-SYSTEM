<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'design_id',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    /**
     * Get the recipient of the conversation based on the current authenticated user.
     */
    public function getRecipient()
    {
        if (auth()->id() === $this->user_id) {
            // If the sender is the user, the recipient is the admin
            return $this->admin;
        }
        
        // If the sender is the admin, the recipient is the user
        return $this->user;
    }
}
