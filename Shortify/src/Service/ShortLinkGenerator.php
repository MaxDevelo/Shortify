<?php

declare(strict_types=1);

namespace App\Service;

use App\Api\ShortLinkGeneratorInterface;
use App\Repository\ShortLinkRepository;

class ShortLinkGenerator implements ShortLinkGeneratorInterface
{
    /**
     * @param ShortLinkRepository $shortLinkRepository
     * 
     * @return void
     */
    public function __construct(
        private ShortLinkRepository $shortLinkRepository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function generate(): string
    {
        while (true) {
            $randomLength = random_int(self::MIN_LENGTH_SHORT_LINK,self::MAX_LENGTH_SHORT_LINK);

            $shortLink = '/' . substr(
                str_shuffle(
                    str_repeat(
                        self::PATTERN,
                        $randomLength
                    )
                ),
                0,
                $randomLength
            );
            
            $shortLinkEntity = $this->shortLinkRepository->verifyShortLinkExists($shortLink);
            
            if(!$shortLinkEntity)
            {
                break;
            }
        }

        return $shortLink;
    }
}