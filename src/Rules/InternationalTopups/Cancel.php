<?php

namespace WeDevBr\Celcoin\Rules\InternationalTopups;

class Cancel
{
    public static function rules()
    {
        return [
            'externalNsu' => ['nullable', 'numeric'],
            'externalTerminal' => ['nullable', 'string'],
        ];
    }
}
