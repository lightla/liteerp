<?php

namespace Core\Notifications\Application\DTOs;

class CreateNotificationRequest
{
    public function __construct(
        public int $user_id,
        public ?string $message = null,
        public ?string $link = null,
        public ?string $title = null,
        public ?string $entity_type,
        public ?int $entity_id,
        public array $chanels = ['db'],
        public ?string $queue = null,
        public ?string $type = null,
        public ?int $business_id = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            message: $data['message'] ?? null,
            link: $data['link'] ?? null,        
            title: $data['title'] ?? null,      
            entity_type: $data['entity_type'] ?? null,
            entity_id: $data['entity_id'] ?? null,
            chanels: $data['chanels']  ?? ['db'],
            queue: $data['queue'] ?? null,
            type: $data['type'] ?? null,
            business_id: $data['business_id'] ?? null
        );
    }
    
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'message' => $this->message,
            'link'    => $this->link, 
            'title'   => $this->title,
            'entity_type' => $this->entity_type,
            'entity_id' => $this->entity_id,
            'chanels' => $this->chanels,
            'queue'   => $this->queue,
            'type'    => $this->type,
            'business_id'   => $this->business_id
        ];
        
    }
}
