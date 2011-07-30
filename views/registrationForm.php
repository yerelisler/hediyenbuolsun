<?php
$h=<<<EOT
<form action="?" method="post" accept-charset="utf-8">
<h5>Kaydol</h5>
<input type="hidden" name="formName" value="registration" />
<ul>
	<li>
		<span class="flabel">
			<label for="rfemail">{$a['email']} :</label>
		</span>
		<span class="felement">
			<input type="text" name="email" value="" id="rfemail">
		</span>
	</li>
	<li>
		<span class="flabel">
			<label for="rfpassword">{$a['password']} :</label>
		</span>
		<span class="felement">
			<input type="PASSWORD" name="password" value="" id="rfpassword">
		</span>
	</li>
	<li>
		<span class="flabel">
			<label for="rfcfrmPassword">{$a['confirmPassword']} :</label>
		</span>
		<span class="felement">
			<input type="PASSWORD" name="cfrmPassword" value="" id="rfcfrmPassword">
		</span>
	</li>
	<li>
		<input type="SUBMIT" value="{$a['submit']}" />
	</li>
</ul>
</form>
EOT;
?>
