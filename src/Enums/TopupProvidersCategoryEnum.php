<?php

namespace WeDevBr\Celcoin\Enums;

enum TopupProvidersCategoryEnum: string
{
    case ALL = '0';
    case PHONE = '1';
    case GAMES = '2';
    case TV = '3';
    case TRANSPORTATION = '4';
    case DIGITAL_CONTENT = '5';
}
