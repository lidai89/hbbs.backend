<?php

namespace site\api;

use site\Service;
use site\dbobject\User;
use site\dbobject\Node;

class StatAPI extends Service
{

   private $_alexaCache = NULL;

   public function get()
   {
      $node = new Node();
      $r = $node->getNodeStat( self::$_city->ForumRootID );

      $alexaCache = $this->_getIndependentCache( 'alexa' );
      $alexa = $alexaCache->fetch();
      if ( !$alexa )
      {
         $alexa = $this->_getAlexa( self::$_city->uriName );
         if ( $alexa )
         {
            $alexaCache->store( $alexa );
         }
      }

      $r[ 'alexa' ] = $alexa;


      $user = new User();
      $u = $user->getUserStat( $this->request->timestamp - 300, self::$_city->id );
      // make some fake guest :)
      if ( $u[ 'onlineCount' ] > 1 )
      {
         $ratio = self::$_city->id == 1 ? 1.2 : 1.5;
         $u[ 'onlineCount' ] = \ceil( $u[ 'onlineCount' ] * $ratio );
         $u[ 'onlineGuestCount' ] = $u[ 'onlineCount' ] - $u[ 'onlineUserCount' ];
      }
      $this->_json( \array_merge( $r, $u ) );
   }

   private function _getAlexa( $city )
   {
      $this->logger->info( 'getting alexa' );
      $data = $this->request->curlGetData( 'http://data.alexa.com/data?cli=10&dat=s&url=http://www.' . $city . 'bbs.com' );

      if ( $data )
      {
         \preg_match( '#<POPULARITY URL="(.*?)" TEXT="([0-9]+){1,}"#si', $data, $p );
         if ( $p[ 2 ] )
         {
            $rank = \number_format( \intval( $p[ 2 ] ) );
            return \ucfirst( $city ) . 'BBS最近三个月平均访问量<a href="http://www.alexa.com/data/details/main?url=http://www.' . $city . 'bbs.com">Alexa排名</a>:<br><a href="http://www.alexa.com/data/details/main?url=http://www.' . $city . 'bbs.com">第 <b>' . $rank . '</b> 位</a> (更新时间: ' . \date( 'm/d/Y H:i:s T', \intval( $_SERVER[ 'REQUEST_TIME' ] ) ) . ')';
         }
         else
         {
            $this->logger->warn( 'Get Alexa Rank Error' );
         }
      }
   }

}

//__END_OF_FILE__