<?php

use Cviebrock\EloquentSluggable\Sluggable;

return [
    'source'             => null,
    'method'             => null,

    // Atur onUpdate false agar slug tidak dapat di update
    'onUpdate'           => true,
    //

    'separator'          => '-',
    'unique'             => true,
    'uniqueSuffix'       => null,
    'firstUniqueSuffix'  => 2,
    'includeTrashed'     => false,
    'reserved'           => null,
    'maxLength'          => null,
    'maxLengthKeepWords' => true,
    'slugEngineOptions'  => [],
];