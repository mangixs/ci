var fileUpload;
function createFileUpload(tag,callback){
	var fileUploadBox=document.createElement('div');
	fileUploadBox.style.display='none';
	fileUploadBox.id='fileUpload';	
	document.getElementsByTagName('body')[0].appendChild( fileUploadBox );
	fileUpload=UE.getEditor('fileUpload');
	tag.addEventListener( 'click',function(){
		var fileDia=fileUpload.getDialog('insertimage');
		fileDia.open();
	} );
	if( typeof(callback)=='function' )
		fileUpload.addListener('beforeinsertimage',callback);
}