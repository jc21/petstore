<?php
/**
 * Tag Model
 */

namespace Petstore\Models;


class Tag extends Base
{


    /**
     * @var string
     */
    protected $table = 'tag';

    /**
     * @var array
     */
    protected $fields = [
        'id'   => null,
        'name' => null,
    ];

    /**
     * Which field is to be used as the identifier
     *
     * @var string
     */
    protected $idField = 'id';
}
