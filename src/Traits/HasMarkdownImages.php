<?php

namespace Developermithu\Tallcraftui\Traits;

use Illuminate\Support\Facades\Storage;

trait HasMarkdownImages
{
    protected static function bootHasMarkdownImages(): void
    {
        static::updating(function ($model) {
            if ($model->isDirty($model->getMarkdownColumn())) {
                $oldImages = self::extractImageUrls($model->getOriginal($model->getMarkdownColumn()));
                $newImages = self::extractImageUrls($model->{$model->getMarkdownColumn()});

                $model->deleteMarkdownImageUrls(array_diff($oldImages, $newImages));
            }
        });

        static::deleting(function ($model) {
            $model->deleteMarkdownImages($model->{$model->getMarkdownColumn()});
        });
    }

    protected function getMarkdownColumn(): string
    {
        return $this->markdownColumn ?? 'content';
    }

    protected function getMarkdownImageDisk(): string
    {
        return $this->markdownImageDisk ?? 'public';
    }

    protected function deleteMarkdownImages(?string $content): void
    {
        if (empty($content)) {
            return;
        }
        $this->deleteMarkdownImageUrls(self::extractImageUrls($content));
    }

    protected function deleteMarkdownImageUrls(array $urls): void
    {
        foreach ($urls as $imageUrl) {
            $path = parse_url($imageUrl, PHP_URL_PATH);
            if ($path) {
                $path = str_replace('/storage/', '', $path);
                if (Storage::disk($this->getMarkdownImageDisk())->exists($path)) {
                    Storage::disk($this->getMarkdownImageDisk())->delete($path);
                }
            }
        }
    }

    protected static function extractImageUrls(?string $content): array
    {
        if (empty($content)) {
            return [];
        }
        preg_match_all('/!\[.*?\]\((.*?)\)/', $content, $matches);

        return $matches[1] ?? [];
    }
}
