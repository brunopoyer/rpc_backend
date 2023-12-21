<?php

namespace App\Enums\Traits;

trait BackedEnum
{
    public static function asOptions(): array
    {
        $reflection = new \ReflectionEnum(self::class);
        // convert cases to array key=>value
        $data = [];
        foreach ($reflection->getCases() as $instance) {
            // remove underscores and capitalize
            $data[$instance->getBackingValue()] = ucwords(str_replace('_', ' ', $instance->getBackingValue()));
        }

        return $data;
    }
}
