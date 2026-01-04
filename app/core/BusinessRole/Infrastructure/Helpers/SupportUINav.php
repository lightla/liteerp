<?php 
namespace Core\BusinessRole\Infrastructure\Helpers;
class SupportUINav {
    public static function build(array $navs, array $roles) {
        $builds = [];
        foreach($navs as $key => $value ) {
            if(in_array($value['ability'],$roles)) {
                $builds[] = $value;
            }
        }
        return $builds;
    }
    public static function buildNavItem(array $data) : array {
        return [
            'to'        => $data['to'] ?? null,
            'link'      => $data['link'] ?? null,
            'icon'      => $data['icon'], 
            'label'     => $data['label'],
            'ability'   => $data['ability'],
        ];
    }
    public static function openNav(string $role): array{
        $navs = config('businessrole.nav');
        $builds = [];
        foreach($navs as $key => $value ) {
            if($role === $value['ability']) {
                $builds = $value;
            }
        }
        return $builds;
    }
}