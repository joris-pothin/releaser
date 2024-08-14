<?php

namespace App;

use Symfony\Component\Serializer\Attribute\SerializedName;

class SongGeneratorDto
{
    private const string GENERATION_TYPE = 'TEXT';
    private const string MV = 'chirp-v3-5';

    public function __construct(
        public ?string $artistClipId = null,
        public ?string $artistEndS = null,
        public ?string $artistStartS = null,
        public ?string $continueAt = null,
        public ?string $continueClipId = null,
        public ?string $coverClipId = null,
        public ?string $generationType = self::GENERATION_TYPE,
        public ?string $infillEndS = null,
        public ?string $infillStartS = null,
        public ?string $mv = self::MV,
        public ?string $prompt = "",
        public ?string $tags = null,
        public ?string $title = null,
        public ?string $gptDescriptionPrompt = null,
        public bool $makeInstrumental = true,
        public array $userUploadedImagesB64 = [],
    ) {
    }
}