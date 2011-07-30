<?php
$h=<<<EOT
<form action="?" method="post" accept-charset="utf-8">
<ul>
	<li>
		<span class="flabel">
			<label for="email">{$a['email']}</label>
		</span>
		<span class="felement">
			<input type="text" name="email" value="" id="email">
		</span>
	</li>
	<li>
		<span class="flabel">
			<label for="password">{$a['password']}</label>
		</span>
		<span class="felement">
			<input type="PASSWORD" name="password" value="" id="password">
		</span>
	</li>
	<li>
		<input type="SUBMIT" value="{$a['submit']}" />
	</li>
</ul>


<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: '193214140732346', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());

function x(){
FB.login(function(response) {
  if (response.session) {
    alert('bağlı');
  } else {
    alert('değil');
  }
});
}

</script>
<fb:login-button></fb:login-button><br /><br />
<input type="button" onclick="x();" value="ok" />

</form>



EOT;
?>
