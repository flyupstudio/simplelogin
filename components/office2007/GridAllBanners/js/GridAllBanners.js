var oldWinRendered = WinRendered;
function DeleteRow() {
	return confirm('Are you sure want to delete?');
}



WinRendered =  function(){
  
	if(typeof(jQuery) != 'undefined'){
		if(jQuery('#Filter,#Filter1,#Filter2,#Filter5').length > 0){
			jQuery('#Filter,#Filter1,#Filter2,#Filter5').chosen();	
		}
	}
	var popups = $$('a.popup');
	if(popups){
		popups.addEvent('click',function(e){
		
			new Event(e).stop();
			window.open (this.href,"mywindow","menubar=1,resizable=1,width=550,height=550"); 
		
		});
	
	}
	
	var ALL_CHECKBOXES = $$("input.MultiplyAllChecks");
	if(ALL_CHECKBOXES){
		
		ALL_CHECKBOXES.each(function(el,i){
			
			el.addEvent('click',function(){
				var ALL_SUB_CHECKS = $$("input.MultiplyOneItemChecks");
				if(ALL_SUB_CHECKS){
					
					ALL_SUB_CHECKS.each(function(_el,j){
						_el.checked = el.checked;
					});
				}
			});
		});
	}
	
	var MULTIPLY_FORM = $('MultiplyConfirmForm');
	if(MULTIPLY_FORM){
		MULTIPLY_FORM.addEvent('submit',function(e){			
			var MULTIPLY_SELECTED = $('MutliplySelect');
			if(MULTIPLY_SELECTED){
				if(MULTIPLY_SELECTED.options[MULTIPLY_SELECTED.selectedIndex].value == 'DeleteSelected'){
					if(!confirm("Are you sure want to delete?")){
						e.stop();
					}
				}
			}
		});
	}
	
	
	var AJAX_LINKS = $$('a.ajax-request');
	if(AJAX_LINKS){		
		AJAX_LINKS.addEvent('click',function(e){
			new Event(e).stop();
			URL = this.href+'&'+this.rel;
			LINK = this;
			
			IMG = LINK.getFirst();
			IMG.src = '/azone/public/images/ajax.gif'
			var req = new Request({
				url: URL,
				onSuccess: function(txt){
					if(LINK.hasClass('on')){
						LINK.rel = 'status=0';
						LINK.removeClass('on');
						LINK.addClass('off');
						IMG.src = '/azone/public/images/unpublic.gif';
					}else{
						LINK.removeClass('off');
						LINK.addClass('on');						
						LINK.rel = 'status=1';
						IMG.src = '/azone/public/images/public.gif';						
					}
				}
			});
			req.send();
		});
	}	
      if(WinRendered1)
		WinRendered1();
	//oldWinRendered = null;
};
