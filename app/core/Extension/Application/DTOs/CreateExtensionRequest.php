<?php

namespace Core\Extension\Application\DTOs;

class CreateExtensionRequest
{
    public function __construct(
        public int $user_id,
        public int $business_id,
        public \Illuminate\Http\UploadedFile $file
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            business_id: $data['business_id'],
            file: $data['file']
        );
    }
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'business_id' => $this->business_id,
            'file' => $this->file
        ];
    }
}