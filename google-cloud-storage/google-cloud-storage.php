<?php

declare(strict_types=1);

use Google\Cloud\Storage\StorageClient;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemException;
use League\Flysystem\Filesystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnableToMoveFile;
use League\Flysystem\UnableToWriteFile;

include __DIR__.'/vendor/autoload.php';

$storageClient = new StorageClient([
    'keyFilePath' => __DIR__ . '/data/google-storage.json',
]);
$bucket = $storageClient->bucket('test2');
$adapter = new GoogleCloudStorageAdapter($bucket);
$filesystem = new Filesystem($adapter);

$files = $filesystem->listContents('/ec2&rds&s3/')
    ->filter(fn (StorageAttributes $attributes) => $attributes->isFile())
    ->sortByPath()
    ->toArray();

echo "Files available in {$bucket->name()}:\n";
/** @var FileAttributes $file */
foreach ($files as $file) {
    printf("- %s,%s,%s\n", $file->fileSize(), $file->mimeType(), $file->path());
}

//upload files
try {
    $filesystem->writeStream('/', fopen(__DIR__ . '/composer.lock', 'r'));
    echo "File was successfully uploaded/written to Google Cloud Storage.";
} catch (FilesystemException | UnableToWriteFile $e) {
    echo "Could not upload/write the file to Google Storage. Reason: {$e->getMessage()}";
}
