window.addEvent('domready', function(){
	
	/*var Tips2 = new Tips($$('.Tips2'), {
		initialize:function(){
			this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 500, wait: false}).set(0);
		},
		onShow: function(toolTip) {
			this.fx.start(1);
		},
		onHide: function(toolTip) {
			this.fx.start(0);
		}
	});
*/
	
	
	if($('start-menu')){
	var start_menu_state = 'hidden'
	
	$('start-menu').set({
		'styles': {
			'opacity': 0, 
			'display': 'block'
		}
	});
	
	$('btn-start-menu').addEvent('click', function(e){
		
		new Event(e).stop();
		
		var show = new Fx.Morph('start-menu', {duration: 400, transition: Fx.Transitions.Sine.easeOut});
		var hide = new Fx.Morph('start-menu', {duration: 400, transition: Fx.Transitions.Sine.easeOut});
		
		show.addEvent('onComplete', function(e){
			
			start_menu_state = 'visible';
		});
		
		hide.addEvent('onComplete', function(e){
			
			start_menu_state = 'hidden';
		});
		
		if(start_menu_state == 'hidden'){
			
			show.start({
				'opacity': [0, 1]
			});
		}
		else {
			
			hide.start({
				'opacity': [1, 0]
			});
		}
	})
	
	$$('body').addEvent('click', function(e){
		
		if(start_menu_state == 'visible'){
		
			var hide = new Fx.Morph('start-menu', {duration: 400, transition: Fx.Transitions.Sine.easeOut});
			hide.addEvent('onComplete', function(e){
				
				start_menu_state = 'hidden';
			});
			hide.start({
				'opacity': [1, 0]
			});
		}
	});	
	}

});
