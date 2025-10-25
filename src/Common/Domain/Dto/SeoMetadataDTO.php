<?php

declare(strict_types=1);

namespace App\Common\Domain\Dto;

use App\Common\Domain\ValueObject\Undefined;

class SeoMetadataDTO
{
    /**
     * @param string|null|Undefined $title Meta title for search results
     * @param string|null|Undefined $description Meta description for search results
     * @param string|null|Undefined $keywords Meta keywords
     * @param string|null|Undefined $ogTitle Open Graph title for social media sharing
     * @param string|null|Undefined $ogDescription Open Graph description for social media
     * @param string|null|Undefined $ogImage Open Graph image URL
     * @param string|null|Undefined $ogType Open Graph content type
     * @param string|null|Undefined $twitterTitle Twitter card title
     * @param string|null|Undefined $twitterDescription Twitter card description
     * @param string|null|Undefined $twitterImage Twitter card image URL
     * @param string|null|Undefined $twitterCard Twitter card type
     * @param string|null|Undefined $canonicalUrl Canonical URL to prevent duplicate content
     * @param bool|Undefined $noIndex Prevent search engines from indexing
     * @param bool|Undefined $noFollow Prevent search engines from following links
     */

    public function __construct(
        public null|string|Undefined $title = new Undefined(),
        public null|string|Undefined $description = new Undefined(),
        public null|string|Undefined $keywords = new Undefined(),
        public null|string|Undefined $ogTitle = new Undefined(),
        public null|string|Undefined $ogDescription = new Undefined(),
        public null|string|Undefined $ogImage = new Undefined(),
        public null|string|Undefined $ogType = new Undefined(),
        public null|string|Undefined $twitterTitle = new Undefined(),
        public null|string|Undefined $twitterDescription = new Undefined(),
        public null|string|Undefined $twitterImage = new Undefined(),
        public null|string|Undefined $twitterCard = new Undefined(),
        public null|string|Undefined $canonicalUrl = new Undefined(),
        public bool|Undefined $noIndex = new Undefined(),
        public bool|Undefined $noFollow = new Undefined()
    )
    {
    }

}
