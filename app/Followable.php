<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Post;
use App\User;

class Followable extends Model
{
    // Table Name
    protected $table = 'followables';
    // Primary Key
    protected $primaryKey = 'fol_id';

    public function user(){
        return $this->belongsTo('App\User');
    } 

    public function post(){
        return $this->belongsTo('App\Post');
    } 

    public function notif(){
        return $this->belongsTo(User::class);
    }

        /**
     * @var array
     */
    protected $with = ['followable'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function followable()
    {
        return $this->morphTo(config('follow.morph_prefix', 'followable'));
    }

    public function scopePopular($query, $type = null)
    {
        $query->select('users.id', 'users.name','followable_id', 'followable_type', \DB::raw('COUNT(*) AS count'))
                        ->join('posts', 'posts.id', '=', 'followables.followable_id')
                        ->join('users', 'users.id', '=', 'posts.user_id')
                        ->groupBy('followable_id', 'followable_type')
                        ->orderByDesc('count');

        if ($type) {
            $query->where('followable_type', $this->normalizeFollowableType($type));
        }

        return $query;
    }

        /**
     * @param string $type
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    protected function normalizeFollowableType($type)
    {
        $morphMap = Relation::morphMap();

        if (!empty($morphMap) && in_array($type, $morphMap, true)) {
            $type = array_search($type, $morphMap, true);
        }

        if (class_exists($type)) {
            return $type;
        }

        $namespace = config('follow.model_namespace', 'App');

        $modelName = $namespace.'\\'.studly_case($type);

        if (!class_exists($modelName)) {
            throw new InvalidArgumentException("Model {$modelName} not exists. Please check your config 'follow.model_namespace'.");
        }

        return $modelName;
    }
}
