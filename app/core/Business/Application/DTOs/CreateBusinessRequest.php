<?php

namespace Core\Business\Application\DTOs;

class CreateBusinessRequest
{
    public function __construct(
        public string $name,
        public string $address,
        public ?int $user_id,
        public string $tax_code,
        public string $phone,
        public string $email,
        public ?string $logo_url = null,
        public string $bank_name,
        public string $bank_account_number,
        public string $bank_account_name,
        public ?int $id = null 
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            address: $data['address'],
            user_id: $data['user_id'] ?? null,
            tax_code: $data['tax_code'],
            phone: $data['phone'],
            email: $data['email'],
            logo_url: $data['logo_url'] ?? null,
            bank_name: $data['bank_name'],
            bank_account_number: $data['bank_account_number'],
            bank_account_name: $data['bank_account_name'],
            id: $data['id'] ?? null 
        );
    }
    public function toArray() : array{
        return [
            'name' => $this->name,
            'address' => $this->address,
            'user_id' => $this->user_id,
            'tax_code'  => $this->tax_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'logo_url'  => $this->logo_url,
            'bank_name' => $this->bank_name,
            'bank_account_number'   => $this->bank_account_number,
            'bank_account_name' => $this->bank_account_name,
            'id'    => $this->id
        ];
    }
}