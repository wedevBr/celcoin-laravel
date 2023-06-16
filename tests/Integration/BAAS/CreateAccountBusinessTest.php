<?php

namespace Tests\Integration\BAAS;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Enums\AccountOnboardingTypeEnum;
use WeDevBr\Celcoin\Types\BAAS\AccountBusiness;
use WeDevBr\Celcoin\Types\BAAS\Address;
use WeDevBr\Celcoin\Types\BAAS\Owner;

class CreateAccountBusinessTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessCreateAccountBusiness()
    {
        $baas = new CelcoinBAAS();
        $accountBusiness = new AccountBusiness();
        $accountBusiness->clientCode = '8b6e666a-0869-46bc-87d8-b32b9d5e1d06';
        $accountBusiness->accountOnboardingType = AccountOnboardingTypeEnum::from('BANKACCOUNT');
        $accountBusiness->documentNumber = '93932977000128';
        $accountBusiness->contactNumber = '+551239215555';
        $accountBusiness->businessEmail = 'teste@email.com';
        $accountBusiness->businessName = 'Julia e Kaique Mudancas ME';
        $accountBusiness->tradingName = 'IPay Julia';

        $address = new Address();
        $address->postalCode = '88080320';
        $address->street = 'Rua Sao Cristovao';
        $address->number = '620';
        $address->addressComplement = 'CJ 1604';
        $address->neighborhood = 'Coqueiros';
        $address->city = 'Florianopolis';
        $address->state = 'SC';
        $address->longitude = '-23.6288';
        $address->latitude = '-46.6488';

        $owner = new Owner();
        $owner->documentNumber = '21025996046';
        $owner->fullName = 'Julia Kaique';
        $owner->phoneNumber = '+5512981175554';
        $owner->email = 'teste@email.com';
        $owner->motherName = 'Maria Julia Kaique';
        $owner->socialName = 'Maria';
        $owner->birthDate = '02-04-2016';
        $owner->address = $address;
        $owner->isPoliticallyExposedPerson = false;

        $accountBusiness->owner = [$owner];
        $accountBusiness->businessAddress = $address;

        $baas->createAccountBusiness($accountBusiness);

        $this->assertTrue($baas instanceof CelcoinBAAS);
    }
}
