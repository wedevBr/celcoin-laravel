<?php

namespace WeDevBr\Celcoin\Clients;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\AccountBusiness as BAASAccountBusiness;
use WeDevBr\Celcoin\Rules\BAAS\AccountManagerBusiness as BAASAccountManagerBusiness;
use WeDevBr\Celcoin\Rules\BAAS\AccountManagerNaturalPerson as BAASAccountManagerNaturalPerson;
use WeDevBr\Celcoin\Rules\BAAS\AccountNaturalPerson as BAASAccountNaturalPerson;
use WeDevBr\Celcoin\Rules\BAAS\AccountRelease as BAASAccountRelease;
use WeDevBr\Celcoin\Types\BAAS\AccountBusiness;
use WeDevBr\Celcoin\Types\BAAS\AccountManagerBusiness;
use WeDevBr\Celcoin\Types\BAAS\AccountManagerNaturalPerson;
use WeDevBr\Celcoin\Types\BAAS\AccountNaturalPerson;
use WeDevBr\Celcoin\Types\BAAS\AccountRelease;

/**
 * Class CelcoinBAAS
 * @package WeDevBr\Celcoin
 */
class CelcoinBAAS extends CelcoinBaseApi
{
    public function createAccountNaturalPerson(AccountNaturalPerson $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountNaturalPerson::rules());
        return $this->post(
            "/baas-onboarding/v1/account/natural-person/create",
            $body
        );
    }

    public function updateAccountNaturalPerson(string $account, string $documentNumber, AccountManagerNaturalPerson $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountManagerNaturalPerson::rules());
        return $this->put(
            "/baas-accountmanager/v1/account/natural-person?Account={$account}&DocumentNumber={$documentNumber}",
            $body
        );
    }

    public function getInfoAccountNaturalPerson(?string $account, string $documentNumber)
    {
        return $this->get(
            "/baas-accountmanager/v1/account/business",
            ['Account' => $account, 'DocumentNumber' => $documentNumber]
        );
    }

    public function getListInfoAccountNaturalPerson(Carbon $dateFrom, Carbon $dateTo, ?int $page = 1, ?int $limit = null)
    {
        return $this->get(
            "/baas-accountmanager/v1/account/fetch",
            ['DateFrom' => $dateFrom->format('Y-m-d'), 'DateTo' => $dateTo->format('Y-m-d'), 'Page' => $page, 'Limite' => $limit]
        );
    }

    public function createAccountBusiness(AccountBusiness $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountBusiness::rules());
        return $this->post(
            "/baas-onboarding/v1/account/business/create",
            $body
        );
    }

    public function updateAccountBusiness(string $account, string $documentNumber, AccountManagerBusiness $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountManagerBusiness::rules());
        return $this->put(
            "/baas-accountmanager/v1/account/business?Account={$account}&DocumentNumber={$documentNumber}",
            $body
        );
    }

    public function getInfoAccountBusiness(?string $account, ?string $documentNumber)
    {
        return $this->get(
            "/baas-accountmanager/v1/account/fetch-business",
            ['Account' => $account, 'DocumentNumber' => $documentNumber]
        );
    }

    public function getListInfoAccountBusiness(Carbon $dateFrom, Carbon $dateTo, ?int $page = 1, ?int $limit = null)
    {
        return $this->get(
            "/baas-accountmanager/v1/account/fetch-all-business",
            ['DateFrom' => $dateFrom->format('Y-m-d'), 'DateTo' => $dateTo->format('Y-m-d'), 'Page' => $page, 'Limite' => $limit]
        );
    }

    public function accountCheck(?string $onboardingId = null, ?string $clientCode = null)
    {
        return $this->get(
            "/baas-onboarding/v1/account/check",
            ["onboardingId" => $onboardingId, "clientCode" => $clientCode]
        );
    }

    public function disableAccount(string $account, string $documentNumber, string $reason)
    {
        return $this->put(
            "/baas-accountmanager/v1/account/status?Account={$account}&DocumentNumber={$documentNumber}",
            ["status" => "BLOQUEADO", "reason" => $reason]
        );
    }

    public function activeAccount(string $account, string $documentNumber, string $reason)
    {
        return $this->put(
            "/baas-accountmanager/v1/account/status?Account={$account}&DocumentNumber={$documentNumber}",
            ["status" => "ATIVO", "reason" => $reason]
        );
    }

    public function deleteAccount(string $account, string $documentNumber, string $reason)
    {
        return $this->delete(
            "/baas-accountmanager/v1/account/close?Account={$account}&DocumentNumber={$documentNumber}&Reason{$reason}"
        );
    }

    public function getWalletBalance(string $account, string $documentNumber)
    {
        return $this->delete(
            "/baas-walletreports/v1/wallet/balance?Account={$account}&DocumentNumber={$documentNumber}"
        );
    }

    public function getWalletMovement(string $account, string $documentNumber, Carbon $dateFrom, Carbon $dateTo, ?int $page = 1, ?int $limit = null)
    {
        return $this->get(
            "/baas-walletreports/v1/wallet/movement?Account={$account}&DocumentNumber={$documentNumber}",
            ['DateFrom' => $dateFrom->format('Y-m-d'), 'DateTo' => $dateTo->format('Y-m-d'), 'Page' => $page, 'Limite' => $limit]
        );
    }

    /**
     * @return array|mixed
     * @throws RequestException
     */
    public function createRelease(string $account, AccountRelease $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountRelease::rules());
        return $this->post(
            "/baas-wallet-transactions-webservice/v1/wallet/entry/{$account}",
            $body
        );
    }
}
