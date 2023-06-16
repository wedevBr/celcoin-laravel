<?php

namespace Tests\Integration\BAAS;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Enums\AccountOnboardingTypeEnum;
use WeDevBr\Celcoin\Types\BAAS\AccountNaturalPerson;
use WeDevBr\Celcoin\Types\BAAS\Address;

class CreateAccountNaturalPersonTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessCreateAccountNaturalPerson()
    {
        $baas = new CelcoinBAAS();
        $accountNaturalPerson = new AccountNaturalPerson();
        $accountNaturalPerson->clientCode = '8b6e666a-0869-46bc-87d8-b32b9d5e1d06';
        $accountNaturalPerson->accountOnboardingType = AccountOnboardingTypeEnum::BANK_ACCOUNT;
        $accountNaturalPerson->documentNumber = '21025996046';
        $accountNaturalPerson->phoneNumber = '+5548988319285';
        $accountNaturalPerson->email = 'teset@email.com';
        $accountNaturalPerson->motherName = 'Maria Julia Kaique';
        $accountNaturalPerson->fullName = 'Julia Kaique';
        $accountNaturalPerson->socialName = 'Julia';
        $accountNaturalPerson->birthDate = '02-04-2001';
        $accountNaturalPerson->isPoliticallyExposedPerson = false;

        $address = new Address();
        $address->postalCode = '88080320';
        $address->street = 'Rua São Cristóvão';
        $address->number = '620';
        $address->addressComplement = 'CJ 1604';
        $address->neighborhood = 'Coqueiros';
        $address->city = 'Florianópolis';
        $address->state = 'SC';
        $address->longitude = '-23.6288';
        $address->latitude = '-46.6488';
        $accountNaturalPerson->address = $address;

        $baas->createAccountNaturalPerson($accountNaturalPerson);

        $this->assertTrue($baas instanceof CelcoinBAAS);
    }
}
