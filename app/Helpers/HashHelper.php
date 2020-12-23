<?php


namespace App\Helpers;


class HashHelper
{
    protected function hashToPath(string $hash): string
    {
        $segment1 = mb_substr($hash, 0, 3);
        $segment2 = mb_substr($hash, 3, 3);
        $segment3 = mb_substr($hash, 6, 3);

        return "{$segment1}/{$segment2}/{$segment3}";
    }
}
