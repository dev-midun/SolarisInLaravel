<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Mime\MimeTypes;
use Intervention\Image\ImageManager;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class Attachment extends BaseModel
{
    protected $table = 'attachment';
    protected $defaultSelectColumn = ['id', 'created_at', 'file_name', 'file_size', 'file_extension', 'image_height', 'image_width'];

    protected function casts(): array
    {
        return array_merge(parent::casts(),
        [
            'file_size' => 'integer'
        ]);
    }

    public function getHumanReadableSize(): string
    {
        $size = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $size >= 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    public static function chunkUpload(Request $request, string $saveTo = ""): array|Attachment
    {
        $paramName = $request->input('param_name') ?? "file";
        $tableName = $request->input('table_name');
        $recordId = $request->input('record_id');
        $thumbnail = $request->input('thumbnail') === 'true' ? true : false;

        $receiver = new FileReceiver($paramName, $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
            throw new UploadMissingFileException();
        }

        $save = $receiver->receive();
        $handler = $save->handler();
        if ($save->isFinished()) {
            $file = $save->getFile();

            $imgInfo = [];
            if($thumbnail) {
                $imgInfo['thumbnail'] = 48;
            }

            if($request->has('image_height') && $request->has('image_width')) {
                $imgInfo['image_height'] = $request->input('image_height');
                $imgInfo['image_width'] = $request->input('image_width');
            }

            return self::upload(
                file: $file, 
                table: [
                    "table_name" => $tableName, 
                    "record_id" => $recordId
                ], 
                saveTo: $saveTo, 
                imageInfo: $imgInfo,
                isMove: true
            );
        }

        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }

    public static function upload($file, ?array $table = null, string $saveTo = "", ?array $imageInfo = null, $isMove = false): Attachment
    {
        $id = (string) Str::orderedUuid();
        $filename = $extension = '';
        $filesize = 0;
        $fileContent = null;

        if ($file instanceof \Illuminate\Http\UploadedFile) {
            
            $filename = $file->getClientOriginalName();
            $filesize = $file->getSize();
            $fileContent = $file->get();

        } else if(filter_var($file, FILTER_VALIDATE_URL)) {

            $fileUpload = self::handleFileUrl($file);
            $filename = $fileUpload['filename'];
            $filesize = $fileUpload['filesize'];
            $fileContent = $fileUpload['fileContent'];

        } else {
            throw new \Exception("File is not supported");
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $newFilename = str_replace("-", "", $id).".{$extension}";
        $path = !empty($saveTo) ? rtrim($saveTo, '/') . '/' : '';

        if($isMove) {
            $file->move(storage_path("app/public/{$path}"), $newFilename);
            $path .= $newFilename;
        } else {
            $path .= $newFilename;
            Storage::disk('public')->put($path, $fileContent);
        }

        $imgExt = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        $thumbnail = !is_null($imageInfo) && isset($imageInfo['thumbnail']) ? $imageInfo['thumbnail'] : null;
        if(!is_null($thumbnail) && in_array(strtolower($extension), $imgExt)) {
            $manager = ImageManager::gd();
            $thumbnail = $manager->read($fileContent)->scale(width: $thumbnail, height: $thumbnail)->toWebp(80);
            $thumbnailPath = "thumbnail/".str_replace(".{$extension}", ".webp", $path);
            Storage::disk('public')->put($thumbnailPath, $thumbnail);
        }

        return self::create([
            'id' => $id,
            'file_name' => $filename,
            'file_size' => $filesize,
            'file_extension' => $extension,
            'table_name' => !is_null($table) && isset($table['table_name']) ? $table['table_name'] : '',
            'record_id' => !is_null($table) && isset($table['record_id']) ? $table['record_id'] : null,
            'path' => $path,
            'image_height' => !is_null($imageInfo) && isset($imageInfo['image_height']) ? $imageInfo['image_height'] : null,
            'image_width' => !is_null($imageInfo) && isset($imageInfo['image_width']) ? $imageInfo['image_width'] : null
        ]);
    }

    private static function handleFileUrl(string $file): array
    {
        $response = Http::get($file);
        if(!$response->successful()) {
            throw new \Exception("File cannot downloaded");
        }

        $contentDisposition = $response->header('Content-Disposition');
        $contentType = $response->header('Content-Type');

        if(!empty($contentDisposition)) {
            preg_match('/filename="([^"]+)"/', $contentDisposition, $matches);

            $filename = $matches[1] ?? "";
        } else if(!empty($contentType)) {
            $mimeTypes = new MimeTypes();

            $filename = basename(parse_url($file, PHP_URL_PATH));
            if(empty(pathinfo($filename, PATHINFO_EXTENSION))) {
                $filename .= '.' . $mimeTypes->getExtensions($contentType)[0];
            }
        } else {
            $filename = basename(parse_url($file, PHP_URL_PATH));
        }
        
        $fileContent = $response->body();
        $filesize = strlen($file);

        return [
            'filename' => $filename,
            'filesize' => $filesize,
            'fileContent' => $fileContent,
        ];
    }
    
    public static function download($id)
    {
        $attachment = self::find($id);
        if (!$attachment) {
            throw new \Exception("Attachment not found.");
        }

        $path = $attachment->path;
        if (!Storage::disk('public')->exists($path)) {
            throw new \Exception("Attachment not found.");
        }

        return Storage::disk('public')->download($path, $attachment->file_name);
    }

    public static function getImage($id)
    {
        $attachment = self::find($id);
        if (!$attachment) {
            abort(404);
        }

        $path = $attachment->path;
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $ext = $attachment->file_extension;
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        if (!in_array(strtolower($ext), $allowedExtensions)) {
            throw new \Exception("File not image");
        }
    
        $mimeType = Storage::mimeType($attachment->path);
        $storagePath = Storage::disk('public')->path($path);
        return response()->file($storagePath, ['Content-Type' => $mimeType]);
    }

    public static function getThumbnail($id)
    {
        $attachment = self::find($id);
        if (!$attachment) {
            abort(404);
        }

        $path = $attachment->path;
        $ext = $attachment->file_extension;

        $path = "thumbnail/".str_replace(".{$ext}", ".webp", $path);
        if (!Storage::disk('public')->exists($path)) {
            return self::getImage($id);
        }

        $mimeType = Storage::mimeType($path);
        $storagePath = Storage::disk('public')->path($path);
        return response()->file($storagePath, ['Content-Type' => $mimeType]);
    }
}