<?php

namespace App\Models\Concerns;

use function str;

/**
 * @method static saving(\Closure $param)
 * @method fill(array $array)
 * @property-read string $body String of markdown to be converted to HTML
 */
trait ConvertsMarkdownToHtml
{
    protected static function bootConvertsMarkdownToHtml(): void
    {
        static::saving(fn ( self $model) => $model->fill(['html' => str($model->body)->markdown([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 5,
        ])]));
    }
}
