<?php

namespace App\Models;

use Beier\FilamentPages\Models\FilamentPage as BeierFilamentPage;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class FilamentPage extends BeierFilamentPage
{
    use HasSEO;

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
        );
    }
}
