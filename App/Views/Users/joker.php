<?php

  foreach ($users as $user) {
    echo $user['id'] . "  --  " ;
    echo $user['user']  . "  --  " ;
    echo $user['pass']  . "  --  ";
    echo $user['email'] . "<br/>";
  }