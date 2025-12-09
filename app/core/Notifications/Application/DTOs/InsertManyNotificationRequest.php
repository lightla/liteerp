<?php

namespace Core\Notifications\Application\DTOs;

use Illuminate\Support\Facades\URL;

class InsertManyNotificationRequest
{
    public function __construct(
        public ?string $title,
        public ?string $message = null,
        public array $role = ['admin','manager'],
        public ?string $link = null,
        public ?string $entity_type,
        public ?int $entity_id,
        public array $chanels = [],
        public ?string $queue = null,
        public ?int $business_id = null,
        public ?string $type = 'info'
    ) {
        
    }

    public static function fromArray(array $data): self
    {
        return new self(
            message: $data['message'],
            link: $data['link'],        
            title: $data['title'] ?? null,      
            entity_type: $data['entity_type'] ?? null,
            entity_id: $data['entity_id'] ?? null,
            chanels: $data['chanels']  ?? [],
            queue: $data['queue'] ?? null,
            role: $data['role'],
            business_id: $data['business_id'] ?? null,
            type: $data['type'] ?? 'info'
        );
    }
    
    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'link'    => $this->link, 
            'title'   => $this->title,
            'entity_type' => $this->entity_type,
            'entity_id' => $this->entity_id,
            'chanels' => $this->chanels,
            'queue'   => $this->queue,
            'role' => $this->role,
            'business_id'   => $this->business_id,
            'type'  => $this->type
        ];
    }
    public function setDanger(){
        $this->type = 'danger';
        $this->message ??= "MS01";
    }
    public function setWarning(){
        $this->type = 'warning';
        $this->message ??= "MS02";
    }
    public function setInfo(){
        $this->type = 'info';
        $this->message ??= "MS03";
    }
}
