<?php
namespace Deepayan\LaraSpeak\Html;


use Illuminate\Contracts\Support\Htmlable;

interface HtmlStringInterface
{
    /**
     * @return Htmlable
     */
    public function toHtmlString();
}
