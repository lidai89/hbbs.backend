<?php

namespace site\controller\node;

use site\controller\Node;
use lzx\html\Template;
use lzx\core\Mailer;
use site\dbobject\Node as NodeObject;
use site\dbobject\Activity;
use site\dbobject\Tag;

class ActivityCtrler extends Node
{

   public function run()
   {
      $this->cache->setStatus( FALSE );
      
      list($nid, $type) = $this->_getNodeType();
      $method = '_activity' . $type;
      $this->$method( $nid );
   }

   private function _activityForumTopic( $nid )
   {
      $node = new NodeObject( $nid, 'tid,uid,title' );

      if ( !$node->exists() )
      {
         $this->request->pageNotFound();
      }

      if ( $node->tid != 16 )
      {
         $this->error( '错误：错误的讨论区。' );
      }

      if ( $this->request->uid != $node->uid && $this->request->uid != 1 )
      {
         $this->logger->warn( 'wrong action : uid = ' . $this->request->uid );
         $this->error( '错误：您只能将自己发表的帖子发布为活动。' );
      }

      if ( empty( $this->request->post ) )
      {
         // display pm edit form
         $tags = $node->getTags( $nid );
         $breadcrumb = [ ];
         foreach ( $tags as $i => $t )
         {
            $breadcrumb[] = [
               'href' => ($i === Tag::FORUM_ID ? '/forum' : ('/forum/' . $i)),
               'title' => $t[ 'description' ],
               'name' => $t[ 'name' ]
            ];
         }
         $breadcrumb[] = ['name' => $node->title ];

         $content = [
            'breadcrumb' => $this->html->breadcrumb( $breadcrumb ),
            'exampleDate' => $this->request->timestamp - ($this->request->timestamp % 3600) + 259200
         ];
         $this->html->var[ 'content' ] = new Template( 'activity_create', $content );
      }
      else
      {
         $this->cache->setStatus( FALSE );
         $startTime = strtotime( $this->request->post[ 'start_time' ] );
         $endTime = strtotime( $this->request->post[ 'end_time' ] );

         if ( $startTime < $this->request->timestamp || $endTime < $this->request->timestamp )
         {
            $this->error( '错误：活动开始时间或结束时间为过去的时间，不能发布为未来60天内的活动。' );
            return;
         }

         if ( $startTime > $this->request->timestamp + 5184000 || $endTime > $this->request->timestamp + 5184000 )
         {
            $this->error( '错误：活动开始时间或结束时间太久远，不能发布为未来60天内的活动。' );
            return;
         }

         if ( $startTime > $endTime )
         {
            $this->error( '错误：活动结束时间在开始时间之前，请重新填写时间。' );
            return;
         }

         if ( $endTime - $startTime > 86400 ) // 1 day
         {

            $mailer = new Mailer();
            $mailer->to = 'admin@houstonbbs.com';
            $mailer->subject = '新活动 ' . $nid . ' 长于一天 (请检查)';
            $mailer->body = $node->title . ' : ' . \date( 'm/d/Y H:i', $startTime ) . ' - ' . \date( 'm/d/Y H:i', $endTime );
            if ( $mailer->send() === FALSE )
            {
               $this->logger->info( 'sending long activity notice email error.' );
            }
         }

         $activity = new Activity();
         $activity->addActivity( $nid, $startTime, $endTime );

         $this->html->var[ 'content' ] = '您的活动申请已经提交并等待管理员激活，一般会在一小时之内被激活并且提交到首页，活动被激活后您将会收到电子邮件通知。';
      }
   }

}

//__END_OF_FILE__