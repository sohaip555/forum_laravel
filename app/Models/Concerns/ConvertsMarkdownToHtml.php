<?php

namespace App\Models\Concerns;




trait ConvertsMarkdownToHtml
{

    protected static function bootConvertsMarkdownToHtml()
    {

        static::saving(function ($model) {
            $markdownDate = collect(self::getMarkdownToHtmlMap())
            ->flip()
            ->map(fn ($bodyColumn) => str($model->$bodyColumn)->markdown([
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
                'max_nesting_level' => 5,
            ]));




            return $model->fill($markdownDate->all());
        });
    }

    public static function getMarkdownToHtmlMap(): array
    {
        return [
            'body' => 'html',
        ];

    }



}
