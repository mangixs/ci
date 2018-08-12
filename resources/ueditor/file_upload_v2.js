var ueObj;
(function(){
	var fileUploadBox=document.createElement('div');
	fileUploadBox.style.display='none';
	fileUploadBox.id='fileUpload';	
	document.getElementsByTagName('body')[0].appendChild( fileUploadBox );
	ueObj=UE.getEditor('fileUpload');
	$.extend(ueObj,{
		fileListenerFn:function(t,arg){console.log(arg)},
		fileUploadCallback:function(fn){
			if( typeof( fn )=='function' ){
				this.removeListener( 'beforeinsertimage',this.fileListenerFn );
				this.fileListenerFn=fn;
				this.addListener( 'beforeinsertimage',this.fileListenerFn );
			}
		}
	});
	$.fn.extend({
		fileUpload:function(fn){
			var self=$(this);
			self.bind('click',function(){
				var dia=ueObj.getDialog('insertimage');
				dia.open();
				ueObj.fileUploadCallback( fn );
			});
		}
	})
})()