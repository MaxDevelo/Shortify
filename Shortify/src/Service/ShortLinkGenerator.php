<?php

declare(strict_types=1);

namespace App\Service;

use App\Api\ShortLinkGeneratorInterface;

class ShortLinkGenerator implements ShortLinkGeneratorInterface
{
    /**
     * {@inheritDoc}
     */
    public function generate(): string
    {
        $shortLink = '/' . substr(
            str_shuffle(
                str_repeat(
                    self::PATTERN,
                    self::LENGTH_SHORT_LINK
                )
            ),
            0,
            self::LENGTH_SHORT_LINK
        );

        return $shortLink;
    }
}