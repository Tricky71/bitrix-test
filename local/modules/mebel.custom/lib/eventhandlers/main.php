<?php

namespace Mebel\Custom\EventHandlers;

class Main 
{
    
    static function redirectFromTestPage(): void
    {
      global $USER, $APPLICATION;
      $curPage = $APPLICATION->GetCurPage();
      if (str_ends_with($curPage, 'test.php') && !$USER->IsAdmin())
      {
        LocalRedirect('/');
      }
    }

}