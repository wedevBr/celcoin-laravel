<?php

namespace WeDevBr\Celcoin\Rules\InternationalTopups;

class Confirm
{
    public static function rules()
    {
        return [
            'externalNSU' => ['required', 'integer'],
            'externalTerminal' => ['required', 'string'],
        ];
    }
}
