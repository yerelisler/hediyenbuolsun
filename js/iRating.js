function iRating(f){
	this.layer=getById(f);
	this.initialize();
	this.imgPath="imgs/common/";
	this.rating=3;
}

var _irtp=iRating.prototype;

_irtp.initialize=function(){
	var t=this;
	
	$('img',this.layer).click(function(){
		t.rate(this.getAttribute('alt'));
	}).mouseover(function(){
		t.starsMouseOver(this);
	}).mouseout(function(){
		t.setRating(t.rating);
	});
}

_irtp.rate=function(point){
	var t=this;
	if(t.rated) return false;
	t.rating=point;
	
	var cmmi=$('input[name="command"]',t.layer).val();
	var parenti=$('input[name="parentId"]',t.layer).val();
	
	var ax=new simpleAjax();
	ax.send(
		'ajax.php',
		'cmm='+cmmi
		+'&parentId='+parenti
		+'&point='+point,
		{'onSuccess':function(rsp,o){
			$('<span class="msg">Thank you!</span>').appendTo(t.layer).hide().slideDown('slow');
			t.rated=true;
		}}	
	);
}

_irtp.starsMouseOver=function(i){
	if(this.rated) return false;
	for(var j=1;j<i.alt;j++)
		$('img[alt="'+j+'"]',this.layer)
			.attr('src',this.imgPath+'star.png');
	
	for(var j=i.alt;j<6;j++)
		$('img[alt="'+j+'"]',this.layer)
			.attr('src',this.imgPath+'star_grey.png');
	
	i.src=this.imgPath+'star.png';
}

_irtp.setRating=function(rating){
	this.rating=rating;
	$('img',this.layer).attr('src',this.imgPath+'star_grey.png');
	for(var j=1;j<=rating;j++)
		$('img[alt="'+j+'"]',this.layer)
			.attr('src',this.imgPath+'star.png');
}
