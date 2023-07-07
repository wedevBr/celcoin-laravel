<?php

namespace WeDevBr\Celcoin\Rules\Topups;

class Confirm
{
    public static function rules()
    {
        return [
            'externalNsu' => ['required', 'integer'],
            'externalTerminal' => ['required', 'string'],
        ];
    }
}
