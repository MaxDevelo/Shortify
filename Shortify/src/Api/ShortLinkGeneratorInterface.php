<?php

declare(strict_types= 1);

namespace App\Api;

interface ShortLinkGeneratorInterface
{
    public const PATTERN = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public const LENGTH_SHORT_LINK = 5;

    /**
     * @return string
     */
    public function generate(): string;
}