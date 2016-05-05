function DeleteRow() {
	
	return confirm('Удалить выбранную запись?');
}


window.addEvent('domready', function(){
	
	
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
					if(!confirm("Удалить выбранную запись?")){
						e.stop();
					}
				}
			}
		});
	}
});