<?php

namespace site\controller;

use site\Controller;
use lzx\core\BBCode;
use lzx\html\HTMLElement;
use lzx\html\Template;
use lzx\core\MySQL;
use site\dbobject\Node as NodeObject;
use site\dbobject\NodeYellowPage;
use site\dbobject\Comment;
use site\dbobject\Image;
use site\dbobject\User;
use site\dbobject\Activity;

class MultiPost extends Controller
{

   public function run()
   {
      $this->cache->setStatus(FALSE);
      parent::run();
      
      $n = new NodeObject();
      $n->uid = 9367;
      $nodes = $n->getList('title,body');
      $str = '';
      foreach ($nodes as $node)
      {
         $str .= (\mb_strlen($node['title']) . '<br />' . $node['title'] . '<br />');
         $str .= (\mb_strlen($node['body']) . '<br />' . $node['body'] . '<br />');
      }
      $this->html->var['content'] = \nl2br($str);
      return;
      if ($len > 50)
      {
         //
         for ($i = 1; $i < 10; $i = $i + 2)
         {
            $start = \intval($len * $i / 10 - 2);
            $sub = \mb_substr($body, $start, 5);
         }
      }

      $n->validatePostContent($request);
      // if $user->ncount() <= 3 and  check
      {
         // get geoip county
         // if $user->geoip->contry != 'US', check
         {

         }
      }
   }

}

//__END_OF_FILE__