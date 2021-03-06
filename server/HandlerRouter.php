<?php declare(strict_types=1);

/**
 * DO NOT EDIT
 * generated by script/build_route.sh
 */

namespace site;

class HandlerRouter
{
    public static $route = [
        'activity'                =>  'site\handler\activity\Handler',
        'ad'                      =>  'site\handler\ad\Handler',
        'api/ad'                  =>  'site\handler\api\ad\Handler',
        'api/adpayment'           =>  'site\handler\api\adpayment\Handler',
        'api/authentication'      =>  'site\handler\api\authentication\Handler',
        'api/bookmark'            =>  'site\handler\api\bookmark\Handler',
        'api/captcha'             =>  'site\handler\api\captcha\Handler',
        'api/file'                =>  'site\handler\api\file\Handler',
        'api/identificationcode'  =>  'site\handler\api\identificationcode\Handler',
        'api/message'             =>  'site\handler\api\message\Handler',
        'api/report'              =>  'site\handler\api\report\Handler',
        'api/stat'                =>  'site\handler\api\stat\Handler',
        'api/user'                =>  'site\handler\api\user\Handler',
        'api/viewcount'           =>  'site\handler\api\viewcount\Handler',
        'app'                     =>  'site\handler\app\Handler',
        'comment/delete'          =>  'site\handler\comment\delete\Handler',
        'comment/edit'            =>  'site\handler\comment\edit\Handler',
        'forum'                   =>  'site\handler\forum\Handler',
        'forum/node'              =>  'site\handler\forum\node\Handler',
        'help'                    =>  'site\handler\help\Handler',
        'home'                    =>  'site\handler\home\Handler',
        'node'                    =>  'site\handler\node\Handler',
        'node/activity'           =>  'site\handler\node\activity\Handler',
        'node/bookmark'           =>  'site\handler\node\bookmark\Handler',
        'node/comment'            =>  'site\handler\node\comment\Handler',
        'node/delete'             =>  'site\handler\node\delete\Handler',
        'node/edit'               =>  'site\handler\node\edit\Handler',
        'node/tag'                =>  'site\handler\node\tag\Handler',
        'search'                  =>  'site\handler\search\Handler',
        'term'                    =>  'site\handler\term\Handler',
        'unsubscribe'             =>  'site\handler\unsubscribe\Handler',
        'yp'                      =>  'site\handler\yp\Handler',
        'yp/join'                 =>  'site\handler\yp\join\Handler',
        'yp/node'                 =>  'site\handler\yp\node\Handler',
    ];
}
