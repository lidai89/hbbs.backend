<?php declare(strict_types=1);

namespace site\handler\api\stat;

use site\Service;
use site\dbobject\Node;
use site\dbobject\User;

class Handler extends Service
{

    public function get(): void
    {
        $node = new Node();
        $r = $node->getNodeStat(self::$city->tidForum);

        $alexaCache = $this->getIndependentCache('alexa');
        $alexa = $alexaCache->fetch();
        if (!$alexa) {
            $alexa = $this->getAlexa(self::$city->uriName);
            if ($alexa) {
                $alexaCache->store($alexa);
            }
        }

        $r['alexa'] = $alexa;


        $user = new User();
        $u = $user->getUserStat($this->request->timestamp - 300, self::$city->id);
        // make some fake guest :)
        if ($u['onlineCount'] > 1) {
            $ratio = self::$city->id == 1 ? 1.2 : 1.5;
            $u['onlineCount'] = ceil($u['onlineCount'] * $ratio);
            $u['onlineGuestCount'] = $u['onlineCount'] - $u['onlineUserCount'];
        }
        $this->json(array_merge($r, $u));
    }

    private function getAlexa(string $city): string
    {
        $data = self::curlGet('http://data.alexa.com/data?cli=10&dat=s&url=' . $city . 'bbs.com');

        if ($data) {
            preg_match('#<POPULARITY URL="(.*?)" TEXT="([0-9]+){1,}"#si', $data, $p);
            if ($p[2]) {
                $rank = number_format(intval($p[2]));
                return ucfirst($city) . 'BBS最近三个月平均访问量<a href="https://www.alexa.com/siteinfo/' . $city . 'bbs.com">Alexa排名</a>:<br><a href="https://www.alexa.com/siteinfo/' . $city . 'bbs.com">第 <b>' . $rank . '</b> 位</a> (更新时间: ' . date('m/d/Y H:i:s T', intval($_SERVER['REQUEST_TIME'])) . ')';
            }
        }

        $this->logger->warn('Get Alexa Rank Error');
        return '';
    }
}
