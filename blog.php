<?php
session_start();

if (!isset($_SESSION['user_Id'])) {
    header("Location: login.php");
    exit();
}


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

include 'blog.html';
?>

<script>
  (function(){
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function(){
      window.history.pushState(null, "", window.location.href);
    };
    window.addEventListener("pageshow", function(event){
      if(event.persisted) location.reload();
    });
  })();
</script>
