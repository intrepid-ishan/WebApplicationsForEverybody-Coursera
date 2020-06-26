<?php
  if ( !isset($_POST['val']) ) return;
  sleep(5);//because of this code is delayed
  echo('You sent: '.$_POST['val'])."<br>";
  echo('#imp:this is output of autoecho and you are using it in autopost with help of datavariable');
