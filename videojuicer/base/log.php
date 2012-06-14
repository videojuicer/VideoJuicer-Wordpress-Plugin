<?php
  if ( !class_exists("Ion_Log") ) {
    class Ion_Log 
    {

        public static $logpath = "error.log";

        public static function log ($message , $level ) {
          if ( ENV != 'production' ) {
            $logfile = fopen ( self::$logpath , 'a+');
            fwrite ( $logfile , date("Y-m-d H:i:s") ." - [".$level."] ".$message.PHP_EOL);
            fclose( $logfile );
          }
        }

        public static function  __callStatic($name , $args) {
          self::log($args[0] , $name);
        } 
    }
  }