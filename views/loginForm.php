<?php
$h=<<<EOT
<form action="?" method="post" accept-charset="utf-8">
<input type="hidden" name="formName" value="login" />
<h5>Giriş Yap</h5>
<ul>
	<li>
		<span class="flabel">
			<label for="email">{$a['email']} :</label>
		</span>
		<span class="felement">
			<input type="text" name="email" value="" id="email">
		</span>
	</li>
	<li>
		<span class="flabel">
			<label for="password">{$a['password']} :</label>
		</span>
		<span class="felement">
			<input type="PASSWORD" name="password" value="" id="password">
		</span>
	</li>
	<li>
		<input type="SUBMIT" value="{$a['submit']}" />
	</li>
</ul>
</form>
EOT;
?>
