<?php

namespace site\handler\single;

use site\handler\single\Single;
use lzx\html\Template;
use lzx\cache\PageCache;

/**
 * @property \lzx\db\DB $db database object
 */
class Handler extends Single
{
    // show activity details
    public function run()
    {
        $this->cache = new PageCache($this->request->uri);

        $a = array_pop($this->db->query('CALL get_latest_single_activity()'));

        $this->var['title'] = $a['name'];
        $this->var['content'] = new Template('home', [
            'activity' => new Template('join_form', ['activity' => $a]),
            'comments' => $this->getComments($a['id']),
            'statistics' => $this->getChart($a)
        ]);
    }
}

//__END_OF_FILE__