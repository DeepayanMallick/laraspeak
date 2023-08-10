<?php

namespace Deepayan\LaraSpeak\Conversations;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';
    public $timestamps = true;
    public $fillable = [
        'user_one',
        'user_two',
        'status',
    ];

    /*
     * make a relation between message
     *
     * return collection
     * */
    public function messages()
    {
        return $this->hasMany('Deepayan\LaraSpeak\Messages\Message', 'conversation_id')
            ->with('sender');
    }
    
    /*
     * make a relation between first user from conversation
     *
     * return collection
     * */
    public function userone()
    {
        return $this->belongsTo(config('laraspeak.user.model', 'App\Models\User'),  'user_one', config('laraspeak.user.ownerKey'));
    }

    /*
   * make a relation between second user from conversation
   *
   * return collection
   * */
    public function usertwo()
    {
        return $this->belongsTo(config('laraspeak.user.model', 'App\Models\User'),  'user_two', config('laraspeak.user.ownerKey'));
    }
}
