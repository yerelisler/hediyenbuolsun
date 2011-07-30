function iComments(f,cmnList){
	this.form=getById(f);
	this.cmnList=getById(cmnList);
	this.initialize();
}

var _icmp=iComments.prototype


_icmp.initialize=function(){
	var t=this;
	this.form.onsubmit=function(){return t.submit();}
}


_icmp.submit=function(){
	var commenti=this.form.commentInput;
	var authori=this.form.authorInput;
	
	if(authori.value.length<2){
		alert('Please type your name.');
		authori.focus();
	}
	else if(commenti.value.length<2){
		alert('Please type your comment.');
		commenti.focus();
	}
	else if(commenti.value.length>1499){
		alert('Your comment is too long.');
		commenti.focus();
	}
	else{
		return this.submitByAjax();
	}
	return false;
}

_icmp.submitByAjax=function(){
	var t=this;
	var authori=t.form.authorInput;
	var commenti=t.form.commentInput;
	var cmmi=t.form.cmm;
	var parenti=t.form.parentId;
	var ax=new simpleAjax();
	
	t.form.sbtn.disabled=true;
	$('.ajaxmsg',t.form).html('Please wait...').hide().fadeIn('slow');
	
	ax.send(
		'ajax.php',
		'cmm='+cmmi.value
		+'&parentId='+parenti.value
		+'&author='+authori.value
		+'&comment='+commenti.value,
		{'onSuccess':function(rsp,o){
			if(rsp!==1){
				t.insertComment(authori.value,commenti.value,new Date());
				$(t.form).hide('normal');
			}
			else{
				alert('Error: '+rsp);
			}
			t.form.sbtn.disabled=false;
		}
	});
	
	return false;
}

_icmp.insertComment=function(author,comment,cDate){
	var li=quickCreate('li');
	var dspan=quickCreate('span');
	var aspan=quickCreate('span');
	var p=quickCreate('p');
	
	li.setAttribute('class','justnow owner');
	dspan.setAttribute('class','date');
	aspan.setAttribute('class','author');
	
	p.innerHTML=nl2br(comment);
	aspan.innerHTML=author;
	
	dspan.innerHTML=cDate.getDate()+
		' '+getMonthName(cDate.getMonth()-1)+
		' '+cDate.getFullYear()+
		' '+cDate.getHours()
		':'+cDate.getMinutes();
	
	appendChilds(li,dspan,aspan,p);
	$(li).hide().prependTo(this.cmnList).slideDown("slow");
	return true;
}
