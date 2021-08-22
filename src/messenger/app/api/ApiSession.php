<?php
namespace messenger\api;
class ApiSession extends ApiBase
{
   public function update($request, $response)
   {
        foreach ($_POST as $key => $value) {
            $_SESSION[$key] = $value;
        }
        error_log(print_r($_SESSION, true));
        return parent::toJson($_SESSION);
   }
}
