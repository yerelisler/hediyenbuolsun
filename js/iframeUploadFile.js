/*
iframe dosya yükleme betiği sürüm 0.5
Tarih: 02 Kasım 2008
Ben: Mustafa Atik 
Detay: http://www.cookingthecode.com/
http://cookingthecode.com/a17_Sayfa-Yenilemeden-Dosya-Yuklemek-(iframe)
Herhangi bir lisansa sahip değil, nasıl isterseniz öyle kullanın.
*/

function iframeUploadFile(vn,url)
{
	this.uploadLimit=3;					// yüklenebilecek maksimum dosya sayısı.
	this.uploadCount=0;					// yüklenmiş dosya sayısı
	this.flist;								// yüklenmiş dosyaların gösterileceği liste. Eğer yoksa, kod tarafından oluşturuluyor.
	this.varName=vn;					// Bu sınıftan alınan nesne örneğini tutan değişkenin adı. Sadece nesne oluşturulurken bir kez belirtilmesi yeter.
	this.loadingImg='loading.gif';			// dosya yüklenirken, yükleme işleminin halen devam ettiğini ifade edecek animasyon
	if(url) this.url=url;					// gönderilen dosyaları sunucu tarafndan karşılayacak dosyanın yolu.
	this.tmpContainer=document.documentElement;			// kod ile oluşturulan iframe ve diğer geçici nesneleri barındıracak elementi belirtir.
}
var _protUF=iframeUploadFile.prototype;
_protUF.send=function(browseBox,url)
{
	/*
	browseBox=sunucuya yüklenecek dosyanın seçildiği kutu, file input
	url		 =dosyayı alacak adres  örn: http://sunucu.com/dosyaal.php
	*/
	if(browseBox.value=='') return false;
	if(this.uploadLimit<=this.uploadCount) {alert('En fazla '+this.uploadLimit+' adet dosya yükleyebilirsiniz.'); return false;}
	if(url) this.url=url;
	
	var sesID=Math.floor(Math.random()*9999999);	// bu yükleme işlemi için benzersiz bir numara üretiliyor
	var fr=document.createElement('form');			// dosyanın gönderimini yapacak form oluşturluyor.
	var newBrowseBox=browseBox.cloneNode(true);		// browseBox elementi, yeni oluşturulan forma eklenecek. Çünkü klonlanır ise, ie tarayıcısı bu kutunun değerini sıfırlıyor. Ben de seçim yapılmış kutuyu forma ekledim, kopyasını ise eskisinin yerine. 
	var ifrm=document.createElement('iframe');		// üzerinden dosyanın gönderileceği frame oluşturluyor.  
	
	//bu frame, 'gözat' kutusunu barındıran katmana görünmez olarak ekleniyor.
	//iframe oluşturulduktan hemen sonra bu işlem yapılıyor ki, iframe'in kök nesnesi kullanılabilsin. ie6 nedeniyle yazmak gerkeli
	this.tmpContainer.appendChild(ifrm);
	
	// contnetWindow ie için, contentDocument firefox, opera ve dipeğleri için
	if(ifrm.contentWindow) ifrm.cnt=ifrm.contentWindow; else ifrm.cnt=ifrm.contentDocument;
	
	ifrm.cnt.name='hifrm'+sesID;
	ifrm.id='hifrm'+sesID;
	
	setAttributes(ifrm,[['width',0],['height',0],['border',0],['style','display:none;']]);
	setAttributes(browseBox,[['id',null],['class',null]]);
	setAttributes(fr,[['id','f'+ifrm.id],['target',ifrm.cnt.name],['action',this.url],['method','post'],['encoding','multipart/form-data'],['enctype','multipart/form-data'],['style','display:none']]);
	
	// yeni seçim kutusu, eskisi ile yer değiştiriyor.
	browseBox.parentNode.insertBefore(newBrowseBox,browseBox);
	fr.appendChild(browseBox);
	this.tmpContainer.appendChild(fr);
	
	if(this.fList==null) this.createFileList(newBrowseBox.parentNode);
	this.insetToList(browseBox.value,ifrm.cnt.name);
	
	fr.submit();
	this.checkUploading(ifrm.cnt.name);
	
}

_protUF.createFileList=function(parent)	// parent= yüklenmiş dosya listesini barındıracak katman
{
	var flist=getByClass('ufList',parent);
	if(flist.length>0) flist=flist[0];
	else
	{
		flist=document.createElement('ul');
		flist.setAttribute('class','ufList');
	}
	this.fList=flist;
	parent.appendChild(this.fList);
}

_protUF.insetToList=function(fileName,ifrmID)
{
	var vn=this.varName;
	var li=document.createElement('li');			// eklenecek liste elemanı
	var fname=document.createElement('span');	// dosyanın adını barındıracak
	var abortLink=document.createElement('a');	// iptal bağı
	var loadingImg=document.createElement('img'); 	// yükleniyor resmini gösterecek
	var nameParts=fileName.split(/\\|\//);
	
	fname.innerHTML=nameParts[nameParts.length-1];
	abortLink.innerHTML='İptal';
	abortLink.setAttribute('href','#');
	abortLink.onclick=function(){eval(vn+'.abort("'+ifrmID+'");')};
	setAttributes(loadingImg,[['src',this.loadingImg],['alt','Yükleniyor...']]);
	setAttributes(li,[['class',ifrmID]]);
	
	appendChilds(li,fname,abortLink,loadingImg);
	this.fList.appendChild(li);
	return true;
}
_protUF.checkUploading=function(ifrmID)
{
	var vn=this.varName;
	var ifrm=getById(ifrmID);
	if(!ifrm) return false;
	
	try
	{
		if(ifrm.contentWindow)
			var doc=ifrm.contentWindow.document;
		else
			var doc=ifrm.cnt;
			
		var resp=doc.getElementById('uploadMsg').innerHTML;
		
		// dosya işlemi başarılı ise
		if(resp==1)
		{
			this.changeForUpload(ifrmID,doc.getElementById('newName').innerHTML);
		}
		else
		{
			this.uploadCount--;
			this.changeForError(ifrmID,resp);
		}
		
		// iframe ile yapılacak bir şey kalamdı, siliniyor.
		this.removeTempElements(ifrmID);
	}
	catch(e)
	{
		// henüz dosya yüklenmemiş, dolayısıyla yanıt gelmemişse, bu metodu biraz zaman sonra tekrar çalıştır.
		setTimeout(vn+'.checkUploading(\''+ifrmID+'\')',1800);
		return false;
	}
}
_protUF.changeForError=function(ifrmID,erorMsg)
{
	var vn=this.varName;
	var fLi=getByClass(ifrmID,this.fList)[0];
	var errorTag=getByTag('span',fLi)[0];
	var rmvLink=getByTag('a',fLi)[0];
	
	rmvLink.innerHTML='Kaldır';
	rmvLink.onclick=function(){eval(vn+'.deleteErrorLi("'+ifrmID+'");')};
	errorTag.innerHTML=erorMsg;
	
	getByTag('img',fLi)[0].parentNode.removeChild(getByTag('img',fLi)[0]);
	fLi.setAttribute('class',fLi.className+' '+'error');
}
_protUF.changeForUpload=function(ifrmID,newName)
{
	var vn=this.varName;
	var fLi=getByClass(ifrmID,this.fList)[0];
	var rmvLink=getByTag('a',fLi)[0];
	var hiddenName=document.createElement('input');
	
	setAttributes(hiddenName,[['type','hidden'],['name','newNmae'],['value',newName]]);
	
	rmvLink.innerHTML='Sil';
	rmvLink.onclick=function(){eval(vn+'.deleteFile("'+ifrmID+'");')};
	
	getByTag('img',fLi)[0].parentNode.removeChild(getByTag('img',fLi)[0]);
	fLi.setAttribute('class',ifrmID+' '+'uploaded');
	fLi.appendChild(hiddenName);
}

_protUF.deleteFile=function(ifrmID)
{
	if(!confirm('Dosyayı silmek istiyor musunuz?')) return false;
	var vn=this.varName;
	var fLi=getByClass(ifrmID,this.fList)[0];
	
	var xhr=new simpleAjax()	// httprequest nesnesi
	xhr.send(
		this.url,
		'command=delete&file='+getByTag('input',fLi)[0].value,
		{'onSuccess':function(rps){
				if(rps=='1')
				{
					eval(vn+'.uploadCount--');
					fLi.parentNode.removeChild(fLi);
				}
				else alert('HATA: '+rps);
			}
		}
	);
	return false;
}

_protUF.deleteErrorLi=function(ifrmID)
{
	var fLi=getByClass(ifrmID,this.fList)[0];
	return fLi.parentNode.removeChild(fLi);
}

_protUF.abort=function(ifrmID)
{
	var fLi=getByClass(ifrmID,this.fList)[0];
	this.removeTempElements(ifrmID);
	this.uploadCount--;
	return fLi.parentNode.removeChild(fLi);
}
_protUF.removeTempElements=function(ifrmID)
{
	this.tmpContainer.removeChild(getById(ifrmID));
	this.tmpContainer.removeChild(getById('f'+ifrmID));
}
