<?php

namespace WeDevBr\Celcoin\Enums;

enum DDAWebhooksTypeEventEnum: string
{
    case SUBSCRIPTION = 'Subscription';
    case DELETION = 'Deletion';
    case INVOICE = 'Invoice';
}
