<?php
/* cierra sesión eliminando la cookie*/
setcookie('usuario','1',time()-(60*180));
header('Location:index.php');
?>
