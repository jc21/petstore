<?php
/**
 * PetHasTag Model
 */

namespace Petstore\Models;


class PetHasTag extends Base
{

    /**
     * @var string
     */
    protected $table = 'petHasTag';

    /**
     * @var array
     */
    protected $fields = [
        'id'    => null,
        'petId' => null,
        'tagId' => null,
    ];

    /**
     * Which field is to be used as the identifier
     *
     * @var string
     */
    protected $idField = 'id';
}
