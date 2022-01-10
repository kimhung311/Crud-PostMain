<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileStorageController extends Controller
{
    public function uploadImage(object $file, string $path, bool $isRename = true)
    {
        try {
            $fileName = $this->getFileName($file, $isRename);
            $key = $this->getUploadKey($path, $fileName);
            Storage::disk('s3')->put($key, file_get_contents($file));

            return $fileName;
        } catch (Exception $e) {
            Log::error('[ERROR_S3_UPLOAD_IMAGE] =>' . $e->getMessage());

            return false;
        }
    }

    /**
     * Get file name.
     *
     * @param object $file
     * @param boolean $isRename
     *
     * @return string
     */
    public function getFileName(object $file, bool $isRename = true): string
    {
        $fileName = $file->getClientOriginalName();
        // Check file upload by blob
        if ($fileName === Constants::FILE_BLOB) {
            return Common::encryptFileName(
                Common::generateUuid(),
                Constants::DEFAULT_EXT_FILE_BLOB
            );
        }
        if ($isRename) {
            $fileName = Common::encryptFileName(
                Common::generateUuid(),
                $file->getClientOriginalExtension()
            );
        }

        return $fileName;
    }

    /**
     * Gennerate presigned url has expried time.
     *
     * @param string $name
     * @param string $path
     *
     * @return null|string
     */
    public function getUrl(string $name, string $path)
    {
        try {
            return Storage::disk('s3')->temporaryUrl(
                $this->getUploadKey($path, $name),
                Carbon::now()->addMinutes(config('filesystems.disks.s3.time_presigned_url'))
            );
        } catch (Exception $e) {
            Log::error('ERROR_S3_GET_URL:' . $e->getMessage());

            return null;
        }
    }

    /**
     * Delete image.
     *
     * @param string $name
     * @param string $path
     *
     * @return boolean
     */
    public function deleteImage(string $name, string $path): bool
    {
        try {
            $key = $this->getUploadKey($path, $name);

            return Storage::disk('s3')->delete($key);
        } catch (Exception $e) {
            Log::error('[ERROR_S3_DELETE_IMAGE] =>' . $e->getMessage());

            return false;
        }
    }

    /**
     * Get upload key to s3.
     *
     * @param string $path path.
     * @param string $name name.
     *
     * @return string
     */
    public function getUploadKey(string $path, string $name): string
    {
        return sprintf('%s/%s', $path, $name);
    }

    /**
     * Create s3 pre-signed url.
     *
     * @param string $name
     * @param string $path
     * @return null|string
     */
    public function getPutObjectUrl(string $name, string $path): string
    {
        $filePath = $this->getUploadKey($path, $name);
        $adapter = Storage::disk('s3')->getAdapter();
        $client = $adapter->getClient();
        $bucket = $adapter->getBucket();
        $cmd = $client->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key' => $adapter->getPathPrefix() . $filePath
        ]);
        $request = $client->createPresignedRequest($cmd, '+5 minutes');

        return (string)$request->getUri();
    }
    
}