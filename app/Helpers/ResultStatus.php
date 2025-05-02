<?php

namespace App\Helpers;

class ResultStatus
{
    public bool $success;
    public string|null $message;
    public array|null $errors;

    public function __construct(bool $success, ?string $message = null, ?array $errors = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->errors = $errors;
    }

    public function toArray(): array
    {
        return [
            "success" => $this->success,
            "message" => $this->message,
            "errors" => $this->errors
        ];
    }

    public function toJson($code = 200)
    {
        return response()->json($this->toArray(), $code);
    }
}