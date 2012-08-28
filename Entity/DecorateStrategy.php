<?php

namespace Msi\Bundle\PageBundle\Entity;

class DecorateStrategy
{
    protected $whitelist;
    protected $whitelistPatterns;
    protected $blacklist;
    protected $blacklistPatterns;

    public function __construct(array $whitelist, array $whitelistPatterns, array $blacklist, array $blacklistPatterns)
    {
        $this->whitelist = $whitelist;
        $this->whitelistPatterns = $whitelistPatterns;
        $this->blacklist = $blacklist;
        $this->blacklistPatterns = $blacklistPatterns;
    }

    public function isRouteDecorable($route)
    {
        if (!$route) {
            return false;
        }

        if (!$this->checkWhitelist($route)) {
            return false;
        }

        if (!$this->checkWhitelistPatterns($route)) {
            return false;
        }

        if (!$this->checkBlacklist($route)) {
            return false;
        }

        if (!$this->checkBlacklistPatterns($route)) {
            return false;
        }

        return true;
    }

    protected function checkWhitelist($name)
    {
        if (empty($this->whitelist) || in_array($name, $this->whitelist)) {
            return true;
        }

        return false;
    }

    protected function checkWhitelistPatterns($name)
    {
        if (empty($this->whitelistPatterns)) {
            return true;
        }

        foreach ($this->whitelistPatterns as $pattern) {
            if (!preg_match('@'.$pattern.'@', $name)) {
                return false;
            }
        }

        return true;
    }

    protected function checkBlacklist($name)
    {
        if (empty($this->blacklist) || !in_array($name, $this->blacklist)) {
            return true;
        }

        return false;
    }

    protected function checkBlacklistPatterns($name)
    {
        if (empty($this->blacklistPatterns)) {
            return true;
        }

        foreach ($this->blacklistPatterns as $pattern) {
            if (preg_match('@'.$pattern.'@', $name)) {
                return false;
            }
        }

        return true;
    }
}
