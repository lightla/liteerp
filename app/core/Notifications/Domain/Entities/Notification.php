<?php

namespace Core\Notifications\Domain\Entities;

use Carbon\Carbon;

class Notification
{
    public function __construct(
        public string $user_id,
        public string $message,
        public ?string $link,
        public ?string $title,
        public ?string $entity_type,
        public ?int $entity_id,
        public ?int $id = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        public string $type = 'default'
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            message: $data['message'],
            link: $data['link'] ?? null,        
            title: $data['title'] ?? null,      
            entity_type: $data['entity_type'] ?? null,
            entity_id: $data['entity_id'] ?? null,
            id : $data['id'] ?? null,
            created_at: $data['created_at'] ?? Carbon::now()->format('Y-m-d H:i:s'),
            updated_at: $data['updated_at'] ?? Carbon::now()->format('Y-m-d H:i:s'),
            type: $data['type'] ?? 'default'   
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
            'id'    => $this->id,
            'created_at'    => $this->created_at ?? Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => $this->updated_at ?? Carbon::now()->format('Y-m-d H:i:s'),
            'type'  => $this->type
        ];
    }
    public function setDanger(){
        $this->type = 'danger';
    }
    public function setWarning(){
        $this->type = 'warning';
    }
    public function setInfo(){
        $this->type = 'info';
    }
}