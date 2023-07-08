<?php

namespace WeDevBr\Celcoin\Rules\Topups;

class Cancel
{
    public static function rules()
    {
        return [
            'externalNSU' => ['required', 'integer'],
            'externalTerminal' => ['required', 'string'],
        ];
    }
}
