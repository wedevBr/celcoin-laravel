<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\ClaimAnswer as ClaimAnswerRule;
use WeDevBr\Celcoin\Rules\PIX\ClaimCreate;
use WeDevBr\Celcoin\Rules\PIX\DICTSearch;
use WeDevBr\Celcoin\Rules\PIX\DICTVerify;
use WeDevBr\Celcoin\Types\PIX\Claim;
use WeDevBr\Celcoin\Types\PIX\ClaimAnswer;
use WeDevBr\Celcoin\Types\PIX\DICT;

class CelcoinPIXDICT extends CelcoinBaseApi
{
    public const POST_SEARCH_DICT = '/pix/v1/dict/v2/key';

    public const POST_VERIFY_DICT = '/pix/v1/dict/keychecker';

    public const CLAIM_DICT = '/pix/v1/dict/claim';

    public const CLAIM_CONFIRM = '/pix/v1/dict/claim/confirm';

    public const CLAIM_CANCEL = '/pix/v1/dict/claim/cancel';

    /**
     * @throws RequestException
     */
    public function searchDICT(DICT $dict): ?array
    {
        $body = Validator::validate($dict->toArray(), DICTSearch::rules());

        return $this->post(
            self::POST_SEARCH_DICT,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function verifyDICT(DICT $dict): ?array
    {
        $body = Validator::validate($dict->toArray(), DICTVerify::rules());

        return $this->post(
            self::POST_VERIFY_DICT,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function claim(Claim $claim): ?array
    {
        $body = Validator::validate($claim->toArray(), ClaimCreate::rules());

        return $this->post(
            self::CLAIM_DICT,
            $body
        );
    }

    public function claimConfirm(ClaimAnswer $claim): ?array
    {
        $body = Validator::validate($claim->toArray(), ClaimAnswerRule::rules());

        return $this->post(
            self::CLAIM_CONFIRM,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function claimCancel(ClaimAnswer $claim): ?array
    {
        $body = Validator::validate($claim->toArray(), ClaimAnswerRule::rules());

        return $this->post(
            self::CLAIM_CANCEL,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function claimConsult(string $claimId): ?array
    {
        $body = Validator::validate(['claimId' => $claimId], ['claimId' => ['string', 'uuid']]);

        return $this->get(
            self::CLAIM_CANCEL.'/'.$claimId,
            $body
        );
    }
}
