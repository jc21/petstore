<?php

class PetCest
{
    private $pet = null;


    /**
     * Create Pet
     *
     * @param ApiTester $I
     */
    public function createPetViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');

        $I->sendPOST('/pet', [
            'category'  => [
                'id'   => 1,
                'name' => 'rottweiler',
            ],
            'name'      => 'Ziba',
            'photoUrls' => [],
            'tags'      => [
                ['id' => 1, 'name' => 'female'],
                ['id' => 2, 'name' => 'desexed'],
            ],
            'status'    => 'available',
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => 'Ziba', 'status' => 'available']);

        $this->pet = json_decode($I->grabResponse(), true);
    }


    /**
     * Update Pet
     *
     * @param ApiTester $I
     */
    public function updatePetViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPUT('/pet', [
            'id'     => $this->pet['id'],
            'name'   => 'Shadow',
            'status' => 'sold',
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => 'Shadow', 'status' => 'sold']);

        $this->user = json_decode($I->grabResponse(), true);
    }

}
