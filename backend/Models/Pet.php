<?php
/**
 * Pet Model
 */

namespace Petstore\Models;


class Pet extends Base
{

    const AVAILABLE = 'available';
    const PENDING   = 'pending';
    const SOLD      = 'sold';

    /**
     * @var string
     */
    protected $table = 'pet';

    /**
     * @var array
     */
    protected $fields = [
        'id'         => null,
        'categoryId' => 0,
        'name'       => null,
        'status'     => self::AVAILABLE,
    ];

    /**
     * Which field is to be used as the identifier
     *
     * @var string|array
     */
    protected $idField = 'id';
}
