<?php

namespace Malt;

/**
 * Class ExternalLink
 */
final class Url
{
    /**
     * @var string
     */
    private $protocol;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string[]
     */
    private $queryStringParameters;

    /**
     * @var string
     */
    private $anchor;

    /**
     * Link constructor.
     *
     * @param string   $protocol          Protocol for building the URL
     * @param string   $host              Hostname part of the URL
     * @param string   $path              Path part of the URL
     * @param string[] $queryStringParams List of key-value parameters for building QueryString
     * @param string   $anchor            Anchor part of the URL
     */
    public function __construct($protocol, $host, $path = null, array $queryStringParams = [], $anchor = null)
    {
        $this->protocol = $protocol;
        $this->host = $host;
        $this->path = $path;
        $this->queryStringParameters = $queryStringParams;
        $this->anchor = $anchor;
    }

    public static function createFromString($url): Url
    {
        $urlElements = parse_url($url);
        if (!empty($urlElements)) {

            $queryStringParams = [];
            if (isset($urlElements['query'])) {
                parse_str($urlElements['query'], $queryStringParams);
            }
            $url = new self(
                !empty($urlElements['scheme']) ? $urlElements['scheme'] : null,
                !empty($urlElements['host']) ? $urlElements['host'] : null,
                !empty($urlElements['path']) ? $urlElements['path'] : null,
                !empty($queryStringParams) ? $queryStringParams : [],
                !empty($urlElements['fragment']) ? $urlElements['fragment'] : null
            );

            return $url;
        }
    }

    /**
     * @return string
     */
    public function getFullUrl(): string
    {
        return $this->getProtocol() . '://'
            . $this->getHost()
            . $this->getPath()
            . ($this->getQueryString() !== null ? '?' . $this->getQueryString() : '')
            . ($this->getAnchor() !== null ? '#' . $this->getAnchor() : '');

    }

    /**
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->path !== null && $this->path[0] !== '/' ? '/' . $this->path : $this->path;
    }

    /**
     * Returns protocol for link - i.e. HTTP or HTTPS.
     *
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * Get array of query string parameters i.e. key-value pairs.
     *
     * @return string[]
     */
    public function getQueryStringParameters(): ?array
    {
        return $this->queryStringParameters;
    }

    /**
     * @return string
     */
    public function getAnchor(): ?string
    {
        return $this->anchor;
    }

    /**
     * Get full query string starting wit '?'.
     *
     * @return string
     */
    public function getQueryString(): ?string
    {
        $keyValuePairs = [];
        foreach ($this->getQueryStringParameters() as $key => $value) {
            $keyValuePairs[] = $key . '=' . $value;
        }
        return !empty($keyValuePairs) ? implode('&', $keyValuePairs) : null;
    }


}