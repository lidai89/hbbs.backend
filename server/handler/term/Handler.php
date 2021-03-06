<?php declare(strict_types=1);

namespace site\handler\term;

use lzx\cache\PageCache;
use lzx\html\Template;
use site\Controller;

class Handler extends Controller
{
    public function run(): void
    {
        $this->cache = new PageCache($this->request->uri);

        $sitename = [
            'site_zh_cn' => '缤纷' . self::$city->name . '华人网',
            'site_en_us' => ucfirst(self::$city->uriName) . 'BBS.com'
        ];

        $this->var['content'] = new Template('term', $sitename);
    }
}
