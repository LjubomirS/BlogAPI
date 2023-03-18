<?php

namespace Module4Project\Controller;

use Ramsey\Uuid\Uuid;

class FileController
{
    private string $fileData;
    private string $directory;
    private string $fileName;

    public function __construct(mixed $thumbnail)
    {
        $this->fileData = base64_decode($thumbnail);
        $this->directory = __DIR__ . '/../../public/uploads/';
        $this->fileName = Uuid::uuid4()->toString();
    }

    public function handle(): string
    {
        $fileExtension = $this->getFileExtension($this->fileData);

        $this->fileName .= '.' . $fileExtension;

        $filePath = $this->directory . $this->fileName;

        file_put_contents($filePath, $this->fileData);

        return $this->fileName;
    }

    private function getFileExtension(mixed $fileData): string
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);

        $mime_type = finfo_buffer($fileInfo, $fileData);

        $extension = '';
        if (is_string($mime_type)) {
            $extension = explode('/', $mime_type)[1];
        }

        return $extension;
    }
}
