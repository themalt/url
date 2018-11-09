<?php

declare(strict_types=1);

use Malt\Url;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{
    public function testCreateFromString(): void
    {
        $externalLink = Url::createFromString('https://www.awsomedomain.pl/this/is/a/path?key=value&other=param&query=string#some_anchor');
        $this->assertEquals('https', $externalLink->getProtocol());
        $this->assertEquals('www.awsomedomain.pl', $externalLink->getHost());
        $this->assertEquals('/this/is/a/path', $externalLink->getPath());
        $this->assertEquals('some_anchor', $externalLink->getAnchor());
        $this->assertEquals('https', $externalLink->getProtocol());
        $this->assertEquals('key=value&other=param&query=string', $externalLink->getQueryString());
        $this->assertEquals([
            'key' => 'value',
            'other' => 'param',
            'query' => 'string'
        ], $externalLink->getQueryStringParameters());
    }

    public function testGetFullUrl(): void
    {
        $externalLink = new Url('http', 'awsomedomain.pl', 'superboard', ['bid' => 1, 'fix' => 'yo'], 'doit');
        $this->assertEquals('http://awsomedomain.pl/superboard?bid=1&fix=yo#doit', $externalLink->getFullUrl());

        $externalLink = new Url('http', 'awsomedomain.pl', '/superboard', ['bid' => 1, 'fix' => 'yo'], null);
        $this->assertEquals('http://awsomedomain.pl/superboard?bid=1&fix=yo', $externalLink->getFullUrl());

        $externalLink = new Url('https', 'awsomedomain.pl', 'superboard/list', [], 'godown');
        $this->assertEquals('https://awsomedomain.pl/superboard/list#godown', $externalLink->getFullUrl());

        $externalLink = new Url('https', 'awsomedomain.pl', null, [], 'verynice');
        $this->assertEquals('https://awsomedomain.pl#verynice', $externalLink->getFullUrl());

        $externalLink = new Url('https', 'awsomedomain.pl', 'about-us');
        $this->assertEquals('https://awsomedomain.pl/about-us', $externalLink->getFullUrl());
    }
}