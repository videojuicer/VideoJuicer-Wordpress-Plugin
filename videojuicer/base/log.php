<?php
/*
Videojuicer For Wordpress
Copyright (C) <2012> <Videojuicer>

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

Full Terms can be found on the world wide web at http://opensource.org/licenses/GPL-2.0 or in license
*/
/**
  Simple contextual logger 
**/
  if ( !class_exists("Ion_Log") ) {
    class Ion_Log 
    {
        public static $logpath = "error.log";

        public static function log ($message , $level ) {
          if ( ION_LOGENV == 'production' ) return;

          $logfile = fopen ( self::$logpath , 'a+');
          fwrite ( $logfile , date("Y-m-d H:i:s") ." - [".$level."] ".$message.PHP_EOL);
          fclose( $logfile );
        }

        public static function  __callStatic($name , $args) {
          self::log($args[0] , $name);
        } 
    }
  }