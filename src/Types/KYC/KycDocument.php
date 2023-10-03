<?php

namespace WeDevBr\Celcoin\Types\KYC;

use Storage;
use WeDevBr\Celcoin\Types\Data;

class KycDocument extends Data
{
    public string $path;
    public string $fileName;
    public ?string $contents;
    public ?string $disk;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public function getContents(): string
    {
        if (empty($this->contents)) {
            return Storage::when($this->disk, fn($storage) => $storage->disk($this->disk))->get($this->path);
        }
        return $this->contents;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}
