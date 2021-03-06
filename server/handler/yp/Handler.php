<?php declare(strict_types=1);

namespace site\handler\yp;

use lzx\cache\PageCache;
use lzx\html\Template;
use site\Controller;
use site\dbobject\Node;
use site\dbobject\Tag;

class Handler extends Controller
{
    const NODES_PER_PAGE = 25;

    public function run(): void
    {
        $this->cache = new PageCache($this->request->uri);

        $tid = $this->args ? (int) $this->args[0] : 0;
        if ($tid <= 0) {
            $this->ypHome();
        } else {
            $this->nodeList($tid);
        }
    }

    protected function ypHome(): void
    {
        $tag = new Tag(self::$city->tidYp, 'id');
        $yp = $tag->getTagTree();
        $this->var['content'] = new Template('yp_home', ['tid' => $tag->id, 'yp' => $yp]);
    }

    protected function nodeList(int $tid): void
    {
        $tag = new Tag($tid, 'id');
        $tagRoot = $tag->getTagRoot();
        $tids = implode(',', $tag->getLeafTIDs());

        $breadcrumb = [];
        foreach ($tagRoot as $i => $t) {
            $breadcrumb[$t['name']] = ($i === self::$city->tidYp ? '/yp' : ('/yp/' . $i));
        }

        $node = new Node();
        list($pageNo, $pageCount) = $this->getPagerInfo($node->getNodeCount($tids), self::NODES_PER_PAGE);
        $pager = Template::pager($pageNo, $pageCount, '/yp/' . $tid);

        $nodes = $node->getYellowPageNodeList($tids, self::NODES_PER_PAGE, ($pageNo - 1) * self::NODES_PER_PAGE);

        $nids = array_column($nodes, 'id');

        $contents = [
            'tid' => $tid,
            'cateName' => $tag->name,
            'cateDescription' => $tag->description,
            'breadcrumb' => Template::breadcrumb($breadcrumb),
            'pager' => $pager,
            'nodes' => ($nodes ? $nodes : null),
            'ajaxURI' => '/api/viewcount/' . implode(',', $nids)
        ];
        $this->var['content'] = new Template('yp_list', $contents);
    }
}
