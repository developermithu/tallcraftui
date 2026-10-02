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

    protected function getMarkdownImageFolder(): string
    {
        return trim($this->markdownImageFolder ?? 'markdown', '/');
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
        $disk = Storage::disk($this->getMarkdownImageDisk());

        foreach ($urls as $imageUrl) {
            $path = $this->markdownImagePath($imageUrl);

            if ($path && $disk->exists($path)) {
                $disk->delete($path);
            }
        }
    }

    /**
     * Resolve an image URL to a path on the markdown disk, or null when the URL
     * doesn't point to an image inside the markdown upload folder. Markdown is
     * user content, so never delete anything outside that folder.
     */
    protected function markdownImagePath(string $imageUrl): ?string
    {
        $basePath = rtrim((string) parse_url(Storage::disk($this->getMarkdownImageDisk())->url(''), PHP_URL_PATH), '/');
        $urlPath = rawurldecode((string) parse_url($imageUrl, PHP_URL_PATH));

        if (! str_starts_with($urlPath, $basePath.'/')) {
            return null;
        }

        $path = substr($urlPath, strlen($basePath) + 1);
        $folder = $this->getMarkdownImageFolder();

        if (str_contains($path, '..') || ($folder !== '' && ! str_starts_with($path, $folder.'/'))) {
            return null;
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($extension, config('tallcraftui.upload.mimes'), true) ? $path : null;
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
