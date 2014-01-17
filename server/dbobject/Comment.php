<?php

/**
 * @package lzx\core\DataObject
 */

namespace site\dbobject;

use lzx\db\DBObject;
use lzx\db\DB;

/**
 * @property $id
 * @property $nid
 * @property $uid
 * @property $tid
 * @property $body
 * @property $hash
 * @property $createTime
 * @property $lastModifiedTime
 */
class Comment extends DBObject
{

   public function __construct( $id = null, $properties = '' )
   {
      $db = DB::getInstance();
      $table = 'comments';
      $fields = [
         'id' => 'id',
         'nid' => 'nid',
         'uid' => 'uid',
         'tid' => 'tid',
         'body' => 'body',
         'hash' => 'hash',
         'createTime' => 'create_time',
         'lastModifiedTime' => 'last_modified_time'
      ];
      parent::__construct( $db, $table, $fields, $id, $properties );
   }

   public function delete()
   {
      $this->_db->query( 'INSERT INTO images_deleted (fid, path) SELECT fid, path FROM images AS f WHERE f.cid = ' . $this->cid );
      $this->_db->query( 'DELETE c, f FROM comments AS c LEFT JOIN images AS f ON c.cid = f.cid WHERE c.cid = ' . $this->cid );
      /*
        if (\is_null($this->uid))
        {
        $this->load('uid');
        }
        if (isset($this->uid))
        {
        $this->_db->query('UPDATE users SET points = points - 1 WHERE uid = ' . $this->uid);
        }
       */
   }

   public function getHash()
   {
      return \crc32( $this->body );
   }

   public function add()
   {
      // CHECK USER
      $userInfo = $this->_db->row( 'SELECT create_time AS createTime, last_access_ip AS lastAccessIPInt, status FROM users WHERE id = ' . $this->uid );
      if ( \intval( $userInfo['status'] ) != 1 )
      {
         throw new \Exception( 'This User account cannot post message.' );
      }
      $days = \intval( ($this->createTime - $userInfo['createTime']) / 86400 );
      // registered less than 1 month
      if ( $days < 30 )
      {
         $geo = \geoip_record_by_name( \long2ip( $userInfo['lastAccessIPInt'] ) );
         // not from Texas
         if ( !$geo || $geo['region'] != 'TX' )
         {
            //select (select count(*) from Node where uid = 126 and createTime > unix_timestamp() - 86400) + ( select count(*) from Comment where uid = 126 and createTime > unix_timestamp() - 86400) AS count
            $oneday = \intval( $this->createTime - 86400 );
            $count = $this->_db->val(
                  'SELECT 
                  ( SELECT count(*) FROM nodes WHERE uid = ' . $this->uid . ' AND createTime > ' . $oneday . ' ) +
                  ( SELECT count(*) FROM comments WHERE uid = ' . $this->uid . ' AND createTime > ' . $oneday . ' ) AS c'
            );
            if ( $count >= $days )
            {
               throw new \Exception( 'Quota limitation reached!<br />Your account is ' . $days . ' days old, so you can only post ' . $days . ' messages within 24 hours. <br /> You already have ' . $count . ' message posted in last 24 hours. Please wait for several hours to get more quota.' );
            }
         }
      }

      // check duplicate
      $this->hash = $this->getHash();

      $count = $this->_db->val( 'SELECT count(*) FROM ' . $this->_table . ' WHERE hash = ' . $this->hash . ' AND uid = ' . $this->uid . ' AND create_time > ' . (\intval( $this->createTime ) - 30) );
      if ( $count > 0 )
      {
         throw new \Exception( 'duplicate comment found' );
      }

      parent::add();
   }

   public function update( $properties = '' )
   {
      if ( $properties == '' )
      {
         $this->hash = $this->getHash();
      }
      else
      {
         $f = \explode( ',', $properties );
         if ( \in_array( 'body', $f ) )
         {
            $this->hash = $this->getHash();
            if ( !\in_array( 'hash', $f ) )
            {
               $properties .=',hash';
            }
         }
      }

      if ( isset( $this->hash ) )
      {
         $count = $this->_db->val( 'SELECT count(*) FROM ' . $this->_table . ' WHERE hash = ' . $this->hash . ' AND uid = ' . $this->uid . ' AND createTime > ' . (\intval( $this->lastModifiedTime ) - 30) . ' AND cid != ' . $this->cid );
         if ( $count > 0 )
         {
            throw new \Exception( 'duplicate comment found' );
         }
      }

      parent::update( $properties );
   }

}

//__END_OF_FILE__