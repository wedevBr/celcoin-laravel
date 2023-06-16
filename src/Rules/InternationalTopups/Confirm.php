<?php

namespace WeDevBr\Celcoin\Rules\InternationalTopups;

class Confirm
{
    public static function rules()
    {
        return [
            'externalNsu' => ['nullable', 'numeric'],
            'externalTerminal' => ['nullable', 'string'],
        ];
    }
}
