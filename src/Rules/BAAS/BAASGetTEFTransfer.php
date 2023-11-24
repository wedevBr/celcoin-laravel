<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class BAASGetTEFTransfer
{
    public static function rules(): array
    {
        return [
            'Id' => ['sometimes', 'string', 'max:36', 'required_without_all:ClientRequestId,EndToEndId'],
            'ClientRequestId' => ['sometimes', 'string', 'max:200', 'required_without_all:Id,EndToEndId'],
            'EndToEndId' => ['sometimes', 'string', 'required_without_all:ClientRequestId,Id'],
        ];
    }
}