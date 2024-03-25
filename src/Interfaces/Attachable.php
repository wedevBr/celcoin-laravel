<?php

namespace WeDevBr\Celcoin\Interfaces;

interface Attachable
{
    public function getField(): string;

    public function getContents();

    public function getFileName();

    public function getHeaders(): array;
}