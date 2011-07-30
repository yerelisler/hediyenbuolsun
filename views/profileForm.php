<?php
$h=<<<EOT
<form action="?" method="post" accept-charset="utf-8">
<input type="hidden" name="formName" value="profile" />
<ul>
	<li>
		<label for="fname">{$a['fname']} / {$a['lname']}</label>
		<input type="text" name="fname" value="" id="fname">
		&#47;
		<input type="text" name="fname" value="" id="fname">
	</li>
	<li>
		<label for="email">{$a['email']}</label>
		<input type="text" name="email" value="" id="email">
	</li>
	<li>
		<label for="fname">{$a['website']}</label>
		<input type="text" name="fname" value="" id="">
	</li>
	<li>
		<label for="fname">{$a['biography']}</label>
		<textarea name="biography" rows="8" cols="40"></textarea>
	</li>
	<li>
		<input type="SUBMIT" value="{$a['submit']}" />
	</li>
</ul>
</form>
EOT;
?>
