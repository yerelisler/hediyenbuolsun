<?php
$h=<<<EOT
<form action="?" method="post" accept-charset="utf-8">
<input type="hidden" name="formName" value="pswRecovery" />
<h5>Şifre Hatırlatıcı</h5>
<ul>
	<li>
		<span class="flabel">
			<label for="prfemail">{$a['email']}</label>
		</span>
		<span class="felement">
			<input type="text" name="email" value="" id="prfemail">
		</span>
	</li>
	<li>
		<input type="SUBMIT" value="{$a['submit']}" />
	</li>
</ul>
</form>
EOT;
?>
