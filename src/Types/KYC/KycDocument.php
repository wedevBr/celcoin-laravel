<?php

namespace WeDevBr\Celcoin\Types\KYC;

use Illuminate\Http\File;
use WeDevBr\Celcoin\Types\Data;

class KycDocument extends Data
{
    public string $fileName;
    public string $contents;
    public File $file;

    public function __construct(File $file)
    {
        $data['contents'] = $file->getContent();
        $data['fileName'] = $file->getFilename();
        $data['file'] = $file;
        parent::__construct($data);
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}
