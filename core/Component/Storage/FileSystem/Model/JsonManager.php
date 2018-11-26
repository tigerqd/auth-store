<?php

declare(strict_types=1);

namespace Core\Component\Storage\FileSystem\Model;

class JsonManager implements FileWriterInterface, FileReaderInterface
{
    /**
     * @var string
     */
    protected $storagePath;

    public function __construct(string $storagePath)
    {
        $this->storagePath = $storagePath;
    }

    public function read(string $storageField, string $file): ?array
    {
        return json_decode(
            file_get_contents($this->buildPath($storageField, $file)),
        true);
    }

    public function write(string $storageField, string $key, array $data): void
    {
        file_put_contents(
            $this->buildPath($storageField, $key),
            json_encode($data)
        );
    }

    public function exists(string $storageField, string $file = ''): bool
    {
        if ('' === $file) {
            return file_exists($storageField);
        }

        return file_exists($this->buildPath($storageField, $file));
    }

    private function buildPath(string $storageField, string $file): string
    {
        return sprintf(
            '%s/%s/%s.json',
            $this->storagePath,
            $storageField,
            md5($file)
        );
    }
}