<?php

namespace WeDevBr\Celcoin\Rules\Topups;

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
