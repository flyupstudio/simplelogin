function DeleteRow() {
	
	return confirm('Вы действительно хотите удалить запись?');
}



WinRendered =  function(){

	var popups = $$('a.popup');
	if(popups){
		popups.addEvent('click',function(e){
		
			new Event(e).stop();
			window.open (this.href,"mywindow","menubar=1,resizable=1,width=800,height=600"); 
		
		});
	
	}

};
