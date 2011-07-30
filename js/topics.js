function submitTopicForm(t){
	var f=true;
	$('ul.ufList li').each(function(){
		if($(this).hasClass('uploaded')) return false;
		alert('a file is uploading... please wait.');
		f=false;
	})
	
	return f;
}
