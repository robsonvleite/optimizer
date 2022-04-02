<?php

namespace CoffeeCode\Optimizer;

use JetBrains\PhpStorm\Pure;
use SimpleXMLIterator;
use stdClass;

/**
 * Class CoffeeCode MetaTags
 *
 * @author Robson V. Leite <https://github.com/robsonvleite>
 * @package CoffeeCode\Optimizer
 */
class MetaTags
{
    /** @var SimpleXMLIterator */
    protected SimpleXMLIterator $meta;

    /** @var stdClass */
    protected stdClass $data;

    /** @var array */
    protected array $tags = ["property" => "og", "name" => "twitter"];

    /**
     * MetaTags constructor.
     */
    public function __construct()
    {
        $this->meta = new SimpleXMLIterator("<meta/>");
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * @param $name
     * @return string|null
     */
    public function __get($name): ?string
    {
        return ($this->data->$name ?? null);
    }

    /**
     * @param string|null $title
     * @param string|null $desc
     * @param string|null $url
     * @param string|null $image
     * @return object|null
     */
    public function data(string $title = null, string $desc = null, string $url = null, string $image = null): ?object
    {
        (!$title ?: $this->title = $title);
        (!$desc ?: $this->description = $desc);
        (!$url ?: $this->url = $url);
        (!$image ?: $this->image = $image);

        return $this->data;
    }

    /**
     * @return SimpleXMLIterator
     */
    public function meta(): SimpleXMLIterator
    {
        return $this->meta;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $render = '';

        for ($this->meta->rewind(); $this->meta->valid(); $this->meta->next()) {
            $render .= $this->meta->current()->asXML();
        }

        return urldecode($render);
    }

    /**
     * @param bool $sort
     * @return array
     */
    public function debug(bool $sort = true): array
    {
        $debug = explode("&", implode(">&<", explode("><", $this->render())));

        if ($sort) {
            rsort($debug);
        }

        return $debug;
    }

    /**
     * @param string $meta
     * @param array $attributes
     */
    protected function buildMeta(string $meta, array $attributes): void
    {
        foreach ($attributes as $name => $content) {
            $add = $this->meta->addChild("meta");
            $add->addAttribute($meta, $name);
            $add->addAttribute("content", $content);
        }
    }

    /**
     * @param string $tagName
     * @param string $tagContent
     */
    protected function buildTag(string $tagName, string $tagContent): void
    {
        $this->meta->addChild($tagName, $tagContent);
    }

    /**
     * @param string $rel
     * @param string $href
     */
    protected function buildLink(string $rel, string $href): void
    {
        $link = $this->meta->addChild("link");
        $link->addAttribute("rel", $rel);
        $link->addAttribute("href", $href);
    }

    /**
     * @param string $string
     * @return string
     */
    protected function filter(string $string): string
    {
        return urlencode(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    }
}