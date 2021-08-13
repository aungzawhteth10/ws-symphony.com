<?php
namespace messenger\api;
class ApiBase 
{
   protected $session;
   protected $HtmlHelper;
   public function __construct () {
      $this->session = $_SESSION;
   }
   public function toError($ErrorMsg)
   {
      http_response_code(500);
      die($ErrorMsg);
   }
   public function toJson($rtnData)
   {
      http_response_code(200);
      return json_encode($rtnData, JSON_UNESCAPED_UNICODE);
   }
}
