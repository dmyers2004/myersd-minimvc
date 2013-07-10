<?php
foreach ($unit as $u) {
	echo '<div style="padding: 1%; width:50%; font-size: 12px; background-color: black; color: white; font-family: Courier, mono; margin-top: 12px">'.$u.'</div>';
	echo '<iframe name="inlineframe" src="'.$baseurl.'/'.$u.'" frameborder="1" style="border:1px solid black" scrolling="auto" width="90%" height="25%" marginwidth="0" marginheight="0" frameborder="1"></iframe>';
}
