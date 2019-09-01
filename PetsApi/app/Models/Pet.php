<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsToAlias;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyAlias;

class Pet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'photoUrls',
        'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * One pet belongs to one category.
     * @return BelongsToAlias
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * One pet can be tagged by multiple tags.
     * @return BelongsToManyAlias
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
