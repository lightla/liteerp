<?php 
namespace App\Supports\Forms;
final class FormFieldRender {
    function __construct(
    private string $type = FormFieldType::TEXT,
    private string $value = '',
    private string $key = '',
    private ?array $options = [],
    private string $label = '',
    private string $placeHolder = ''
    ) {

    }
    public function toArray(){
        return $this->options ? [
            'type' => $this->type,
            'value' => $this->value,
            'key' => $this->key,
            'options' => $this->options,
            'label' => $this->label,
            'placeHolder' => $this->placeHolder 
        ] : [
            'type' => $this->type,
            'value' => $this->value,
            'key' => $this->key,
            'label' => $this->label,
            'placeHolder' => $this->placeHolder
        ];
    }
}
