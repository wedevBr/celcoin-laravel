<?php

namespace WeDevBr\Celcoin\Enums;

enum ClaimAnswerReasonEnum: string
{

	case USER_REQUESTED = 'USER_REQUESTED';
	case ACCOUNT_CLOSURE = 'ACCOUNT_CLOSURE';
	case FRAUD = 'FRAUD';
	case DEFAULT_OPERATION = 'DEFAULT_OPERATION';
}