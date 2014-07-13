<?php

namespace site\controller\node;

use site\controller\Node;
use site\dbobject\Node as NodeObject;

class AJAXCtrler extends Node
{

   const COMMENTS_PER_PAGE = 10;

   public function run()
   {
      // url = /node/ajax/viewcount?nid=<nid>

      $viewCount = [ ];
      if ( $this->args[ 0 ] == 'viewcount' )
      {
         $nid = \intval( $this->request->get[ 'nid' ] );
         $nodeObj = new NodeObject( $nid, 'viewCount' );
         if ( $nodeObj->exists() )
         {
            $nodeObj->viewCount = $nodeObj->viewCount + 1;
            $nodeObj->update( 'viewCount' );
            $viewCount[ 'viewCount_' . $nid ] = $nodeObj->viewCount;
         }
      }

      $this->ajax( $viewCount );
   }

}

//__END_OF_FILE__