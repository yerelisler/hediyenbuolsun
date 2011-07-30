$(document).ready(function(){
	
	$('.addShip').click(function(){
		$('#shipForm').toggle('normal');
		
	});
	
	$('a.remove').click(function(){
		if(!confirm('Are you sure?')) return false;
		
	});
	
	$('#shipForm .cancel').click(function(){
		$(this.form).hide('normal');
	})
	
	$('a.checkAllTopics').click(function(){
		$('ul.topics input[class="check"]').attr('checked','checked');
		return false;
	})
	
	$('a.rename').click(function(){
		var t=this;
		var shipId=$('input[name="shipId"]',this.parentNode).val();
		var sName=$('a.shipName',this.parentNode).html();
		var nName=prompt('Rename the ship',sName);
		
		if(nName==sName.value || nName==false || nName==''){
			return false;
		}
		
		var sAjax=new simpleAjax();
		sAjax.send(
			'ajax.php?cmm=shipReanme',
			'shipId='+shipId+'&nName='+encodeURI(nName),
			{'onSuccess':function(rsp){
				if(rsp==1)
					$('a.shipName',t.parentNode).html(nName)
				else
					alert('an error occured.');
			}}
		)
		
		return false;
	});
	
});
