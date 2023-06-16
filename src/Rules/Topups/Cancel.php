<?php

namespace WeDevBr\Celcoin\Rules\Topups;

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
