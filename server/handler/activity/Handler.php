<?php declare(strict_types=1);

namespace site\handler\activity;

use lzx\exception\ErrorMessage;
use lzx\html\Template;
use site\Controller;
use site\dbobject\Activity as ActivityObject;

class Handler extends Controller
{
    const NODES_PER_PAGE = 25;
    public function run(): void
    {
        $act = new ActivityObject();
        $act->status = 1;
        $total = $act->getCount();

        if ($total == 0) {
            throw new ErrorMessage('目前没有活动。');
        }

        list($pageNo, $pageCount) = $this->getPagerInfo($total, self::NODES_PER_PAGE);
        $pager = Template::pager($pageNo, $pageCount, '/activity');

        $limit = self::NODES_PER_PAGE;
        $offset = ($pageNo - 1) * self::NODES_PER_PAGE;
        $actList = $act->getActivityList($limit, $offset);

        foreach ($actList as $k => $n) {
            $type = ($n['start_time'] < $this->request->timestamp) ? (($n['end_time'] > $this->request->timestamp) ? 'activity_now' : 'activity_before') : 'activity_future';
            $data .= '<a href="/node/' . $n['nid'] . '" class="' . $type . '" data-before="' . date('m/d', (int) $n['start_time']) . '">' . $n['title'] . '</a>';
        }

        $contents = [
            'pager' => $pager,
            'data' => $data
        ];

        $this->var['content'] = new Template('activity_list', $contents);
    }
}
