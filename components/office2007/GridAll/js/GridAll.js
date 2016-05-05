var oldWinRendered = WinRendered;
function DeleteRow() {
	return confirm('Are you sure want to delete?');
}


function formatTime(time){
	// create a new javascript Date object based on the timestamp
// multiplied by 1000 so that the argument is in milliseconds, not seconds
 
var a = new Date(time);
var year = "0" + a.getFullYear();
var month = "0" + (a.getMonth()+1);
var date = "0" + a.getDate();

var hours = "0" + a.getHours();
// minutes part from the timestamp
var minutes = "0" + a.getMinutes();
// seconds part from the timestamp
var seconds = "0" + a.getSeconds();

// will display time in 10:30:23 format
var formattedTime = 
					month.substr(month.length-2)+"/"+
					date.substr(date.length-2)+"/"+
					year.substr(year.length-2)+
					" "+
					hours.substr(hours.length-2)+":"+
					minutes.substr(minutes.length-2)+":"+
					seconds.substr(seconds.length-2);

return formattedTime;
	
}
WinRendered =  function(){
	
	jQuery('.needParse').each(function(el,i,all){
		
		if(jQuery(this).data("time")){			
			jQuery(this).html(formatTime(jQuery(this).data("time")));
		}
	})
	
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
	jQuery('.group-nogo').each(function(el, i, all){
		var element = jQuery(this);
		var classList =element.attr('class').split(/\s+/);
		jQuery.each( classList, function(index, item){
		//	alert(item);
			if (item != 'x-tree-node-icon' && 
				item != 'group-nogo') {
			   //do something
			   element.parent().parent('').addClass(item);
			}
		});

		
	});
	
	
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
      if(oldWinRendered)
		oldWinRendered();
	//oldWinRendered = null;
};
