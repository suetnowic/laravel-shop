<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->slug = $model->slug ?? str($model->{self::slugFrom()})->append(time())->slug();
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }

    public static function checkAndIncrementSlug(Model $model, $slug, $attempt = 0)
    {
        if ($attempt > 0) {
            $slug = $slug . '-' . $attempt;
        }
        $count = $model::where('slug', $slug)->count();
        return $count > 0 ? self::checkAndIncrementSlug($slug, $attempt++) : $slug;
    }
}
