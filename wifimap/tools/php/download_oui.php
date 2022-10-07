<?php

file_put_contents("uploads/oui.txt", file_get_contents("https://standards-oui.ieee.org/oui.txt"));
echo "File downloaded";

?>
