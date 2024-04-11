<?php

namespace WeDevBr\Celcoin\Enums;

enum ClaimKeyTypeEnum: string
{

	case CPF = 'CPF';
	case CNPJ = 'CNPJ';
	case EMAIL = 'EMAIL';
	case PHONE = 'PHONE';
}