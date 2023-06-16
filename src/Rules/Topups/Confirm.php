<?php

namespace WeDevBr\Celcoin\Rules\Topups;

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
