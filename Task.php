<?php
class Task{
    protected static $to_do_status = "active";
    protected static $doing_status = "current";
    protected static $done_status = "inactive";

    public static function get_status(){
        return [
            "to_do_status" => self::$to_do_status,
            "doing_status" => self::$doing_status,
            "done_status" => self::$done_status,
        ];
    }
}
?>