<?php

namespace WeDevBr\Celcoin\Types\KYC;

use Illuminate\Http\File;
use WeDevBr\Celcoin\Interfaces\Attachable;
use WeDevBr\Celcoin\Types\Data;

class KycDocument extends Data implements Attachable
{
    public string $fileName;

    public string $contents;

    public ?File $file;

    public string $field;

    public function __construct(?File $file, string $field)
    {
        $data = [];
        if (! empty($file)) {
            $data['contents'] = $file->getContent();
            $data['fileName'] = $file->getFilename();
            $data['field'] = $field;
        }

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

    public function getField(): string
    {
        return $this->field;
    }
}
