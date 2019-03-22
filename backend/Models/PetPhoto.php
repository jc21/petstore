<?php
/**
 * PetPhoto Model
 */

namespace Petstore\Models;


class PetPhoto extends Base
{

    /**
     * @var string
     */
    protected $table = 'petPhoto';

    /**
     * @var array
     */
    protected $fields = [
        'id'  => null,
        'url' => null,
    ];

    /**
     * Which field is to be used as the identifier
     *
     * @var string
     */
    protected $idField = 'id';
}
