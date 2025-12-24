<?php 
namespace Core\Overview\Infrastructure\Helpers;
class Compare {
    public static function handle(int $pre,int $current) : float {
        if($pre === 0) {
            return 100;
        }
        if($current === 0 ) {
            return -100;
        }
        $value = ($pre / $current * 100) - 100;
        if($pre > $current) {
            return round(-abs($value),2);
        }
        return round($value,2);
    }
}