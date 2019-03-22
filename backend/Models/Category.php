<?php
/**
 * Category Model
 */

namespace Petstore\Models;


class Category extends Base
{

    /**
     * @var string
     */
    protected $table = 'category';

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
