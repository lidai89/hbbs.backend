<?php declare(strict_types=1);

namespace site\handler\yp\join;

use lzx\cache\PageCache;
use lzx\html\Template;
use site\Controller;

class Handler extends Controller
{
    public function run(): void
    {
        $this->cache = new PageCache($this->request->uri);

        $this->var['content'] = new Template('yp_join');
        $this->var['head_title'] = '市场推广 先入为主';
    }
}
