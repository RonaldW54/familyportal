<?php

namespace App\Support;

use DateTimeInterface;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class SecureUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        // ERZWINGT die Nutzung unserer sicheren Route
        return route('media.show', ['media' => $this->media]);
    }

    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return $this->getUrl();
    }
}