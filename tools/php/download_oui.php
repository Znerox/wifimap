<?php

file_put_contents("uploads/oui.txt", file_get_contents("http://standards-oui.ieee.org/oui.txt"));
echo "File downloaded";

?>
