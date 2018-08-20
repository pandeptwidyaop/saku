<?php
namespace App;

use Webpatser\Uuid\Uuid as Id;

trait Uuid
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Id::generate()->string;
        });
    }
}
