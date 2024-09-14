<?php

declare(strict_types= 1);

namespace App\Api;

interface ShortLinkGeneratorInterface
{
    public const PATTERN = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public const MIN_LENGTH_SHORT_LINK = 4;
    public const MAX_LENGTH_SHORT_LINK = 10;

    /**
     * @return string
     */
    public function generate(): string;
}