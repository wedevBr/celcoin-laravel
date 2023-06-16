<?php

namespace WeDevBr\Celcoin\Rules\ElectronicTransactions;

class ServicesPoints
{
    public static function rules()
    {
        return [
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'namePartner' => ['required', 'string'],
            'radius' => ['required', 'numeric'],
            'page' => ['required', 'numeric'],
            'size' => ['required', 'numeric'],
        ];
    }
}
