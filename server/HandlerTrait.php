<?php declare(strict_types=1);

namespace site;

use lzx\html\Template;
use site\dbobject\User;
use lzx\cache\CacheHandler;
use lzx\cache\CacheEvent;
use site\dbobject\City;

trait HandlerTrait
{
    protected static $city;
    private static $staticInitialized = false;
    private static $cacheHandler;
    private $independentCacheList = [];
    private $cacheEvents = [];

    private function staticInit()
    {
        if (self::$staticInitialized) {
            return;
        }

        self::$staticInitialized = true;

        // set site info
        $site = preg_replace(['/\w*\./', '/bbs.*/'], '', $this->request->domain, 1);

        Template::setSite($site);

        self::$cacheHandler = CacheHandler::getInstance();
        self::$cacheHandler->setCacheTreeTable(self::$cacheHandler->getCacheTreeTable() . '_' . $site);
        self::$cacheHandler->setCacheEventTable(self::$cacheHandler->getCacheEventTable() . '_' . $site);

        // validate site for session
        self::$city = new City();
        self::$city->uriName = $site;
        self::$city->load();
        if (self::$city->exists()) {
            if (self::$city->id != $this->session->getCityID()) {
                $this->session->setCityID(self::$city->id);
            }
        } else {
            $this->error('unsupported website: ' . $this->request->domain);
        }

        // update user info
        if ($this->request->uid > 0) {
            $user = new User($this->request->uid, null);
            // update access info
            $user->call('update_access_info(' . $this->request->uid . ',' . $this->request->timestamp . ',"' . $this->request->ip . '")');
        }
    }

    public function flushCache()
    {
        if ($this->config->cache) {
            if ($this->cache && $this->response->getStatus() < 300 && Template::hasError() === false) {
                $this->response->cacheContent($this->cache);
                $this->cache->flush();
                $this->cache = null;
            }

            foreach ($this->independentCacheList as $c) {
                $c->flush();
            }

            foreach ($this->cacheEvents as $e) {
                $e->flush();
            }
        }
    }

    protected function getIndependentCache($key)
    {
        $key = self::$cacheHandler->getCleanName($key);
        if (array_key_exists($key, $this->independentCacheList)) {
            return $this->independentCacheList[$key];
        } else {
            $cache = self::$cacheHandler->createCache($key);
            $this->independentCacheList[$key] = $cache;
            return $cache;
        }
    }

    protected function getCacheEvent($name, $objectID = 0)
    {
        $name = self::$cacheHandler->getCleanName($name);
        $objID = (int) $objectID;
        if ($objID < 0) {
            $objID = 0;
        }

        $key = $name . $objID;
        if (array_key_exists($key, $this->cacheEvents)) {
            return $this->cacheEvents[$key];
        } else {
            $event = new CacheEvent($name, $objID);
            $this->cacheEvents[$key] = $event;
            return $event;
        }
    }
}