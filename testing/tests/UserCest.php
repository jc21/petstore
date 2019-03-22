<?php

class UserCest
{
    private $user = null;
    private $users = [];


    /**
     * Create User
     *
     * @param ApiTester $I
     */
    public function createUserViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');

        $I->sendPOST('/user', [
            'username'   => 'jcurnow',
            'firstName'  => 'Jamie',
            'lastName'   => 'Curnow',
            'email'      => 'jc@jc21.com',
            'password'   => 'changeme',
            'phone'      => '043942451541',
            'userStatus' => 0,
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['username' => 'jcurnow']);

        $this->user = json_decode($I->grabResponse(), true);
    }


    /**
     * Login User
     *
     * @param ApiTester $I
     */
    public function loginUserViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/user/login', [
            'username' => $this->user['username'],
            'password' => $this->user['password'],
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }


    /**
     * Logout User
     *
     * @param ApiTester $I
     */
    public function logoutUserViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/user/logout');
        $I->seeResponseCodeIs(200);
    }


    /**
     * Update User
     *
     * @param ApiTester $I
     */
    public function updateUserViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPUT('/user/' . $this->user['username'], [
            'username'   => 'jcurnow-2',
            'password'   => 'changeme',
            'phone'      => '043942451541',
            'userStatus' => 0,
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['username' => 'jcurnow-2', 'firstName' => 'Jamie']);

        $this->user = json_decode($I->grabResponse(), true);
    }


    /**
     * Create multiple Users
     *
     * @param ApiTester $I
     */
    public function createUsersViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPOST('/user/createWithList', [
            [
                'username'   => 'ppots',
                'firstName'  => 'Pepper',
                'lastName'   => 'Potts',
                'email'      => 'pepper@potts.com',
                'password'   => 'changeme',
                'phone'      => '043942451541',
                'userStatus' => 0,
            ],
            [
                'username'   => 'bwidow',
                'firstName'  => 'Black',
                'lastName'   => 'Widoe',
                'email'      => 'black@widow.com',
                'password'   => 'changeme',
                'phone'      => '043942451541',
                'userStatus' => 0,
            ],
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([['username' => 'ppots'], ['username' => 'bwidow']]);

        $this->users = array_merge($this->users, json_decode($I->grabResponse(), true));
    }


    /**
     * Create multiple Users
     *
     * @param ApiTester $I
     */
    public function createUsersViaAPI2(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPOST('/user/createWithArray', [
            [
                'username'   => 'bbanner',
                'firstName'  => 'Bruce',
                'lastName'   => 'Banner',
                'email'      => 'bruce@banner.com',
                'password'   => 'changeme',
                'phone'      => '043942451541',
                'userStatus' => 0,
            ],
            [
                'username'   => 'pmaximoff',
                'firstName'  => 'Pietro',
                'lastName'   => 'Maximoff',
                'email'      => 'Pietro@Maximoff.com',
                'password'   => 'changeme',
                'phone'      => '043942451541',
                'userStatus' => 0,
            ],
        ]);
print '---------------------->'."\n".$I->grabResponse()."\n".'<-------------------------------'."\n";
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([['username' => 'bbanner'], ['username' => 'pmaximoff']]);

        $this->users = array_merge($this->users, json_decode($I->grabResponse(), true));
    }


    /**
     * Delete Users
     *
     * @param ApiTester $I
     */
    public function deleteUsersViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendDELETE('/user/' . $this->user['username']);
        $I->seeResponseCodeIs(200);

        foreach ($this->users as $user) {
            $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
            $I->sendDELETE('/user/' . $user['username']);
            $I->seeResponseCodeIs(200);
        }
    }
}
