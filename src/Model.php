<?php

namespace MikeTiEm\Valkyrie;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use MikeTiEm\Valkyrie\Traits\HasManyRelation;
use MikeTiEm\Valkyrie\Traits\FormatFillable;
use MikeTiEm\Valkyrie\Traits\Destroyable;

abstract class Model extends EloquentModel
{
    use FormatFillable, HasManyRelation, Destroyable;

    protected $values = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * The attribute that should stores all the
     * relationships to verify before destroy.
     *
     * @var array
     */
    protected $relationships = [
        //
    ];

    /**
     * The attributes that will be used to filter.
     *
     * @var array
     */
    protected $filter = [
        //
    ];



}