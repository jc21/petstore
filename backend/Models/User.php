<?php
/**
 * User Model
 */

namespace Petstore\Models;


class User extends Base
{


    /**
     * @var string
     */
    protected $table = 'user';

    /**
     * @var array
     */
    protected $fields = [
        'id'         => null,
        'username'   => null,
        'firstName'  => null,
        'lastName'   => null,
        'email'      => null,
        'password'   => null,
        'phone'      => null,
        'userStatus' => 0,
    ];

    /**
     * Which field is to be used as the identifier
     *
     * @var string
     */
    protected $idField = 'id';
}
