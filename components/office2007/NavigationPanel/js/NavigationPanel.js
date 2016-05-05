window.addEvent('domready', function(){
	
	var panel_state = 'expanded';

	var cell_coord = $('panel-cell').getCoordinates();
	var nav_coord = $('navigation').getCoordinates();
	
	if(cell_coord.height < nav_coord.height) {
		
		var height = nav_coord.height;
		
		$('panel-cell').set({
			'styles': {
				'height': nav_coord.height
			}
		});
	}
	else {
		
		var height = cell_coord.height;
	}
	
	$('npc-bottom').set({
		'styles': {
			'height': height - 27
		}
	});
	
	if(panel_state == 'expanded') {
		
		$('np-collapsed-panel').set({
			'styles': {
				'opacity': 0,
				'display': 'block'
			}
		});
	}
	else {
		
		$('np-collapsed-panel').set({
			'styles': {
				'display': 'block'
			}
		});
		
		$('navigation').set({
			'styles': {
				'opacity': 0
			}
		});
		
		$('navigation-container').set({
			'styles': {
				'width': 24
			}
		});
	}
	
	/*
	$('n-search').addEvent('click', function(e){
		
		if(this.value == this.title) {
			
			this.value = '';
		}
	})

	$('n-search').addEvent('blur', function(e){
		
		if(this.value == '') {
			
			this.value = this.title;
		}
	})
	*/
	
	$('n-close').addEvent('click', function(e){

		new Event(e).stop();
		
		if(panel_state == 'expanded'){

			var hide = new Fx.Morph('navigation', {duration: 500, transition: Fx.Transitions.Sine.easeOut});
			var show = new Fx.Morph('np-collapsed-panel', {duration: 500,transition: Fx.Transitions.Sine.easeOut});
			var width = new Fx.Morph('navigation-container', {duration: 500,transition: Fx.Transitions.Sine.easeOut});
			
			show.addEvent('onComplete', function(e){
			
				panel_state = 'collapsed';
			});
			
			show.addEvent('onComplete', function(e){
			
				width.start({
					'width': [207, 24]
				});
			});
			
			hide.start({
				
				'opacity': [1, 0]
			});
			
			show.start({
				
				'opacity': [0, 1]
			});
		}
	});

	$('n-open').addEvent('click', function(e){

		new Event(e).stop();
		
		if (panel_state == 'collapsed') {
		
			var show = new Fx.Morph('navigation', {duration: 500, transition: Fx.Transitions.Sine.easeOut});
			var hide = new Fx.Morph('np-collapsed-panel', {duration: 500,transition: Fx.Transitions.Sine.easeOut});
			var width = new Fx.Morph('navigation-container', {duration: 500, transition: Fx.Transitions.Sine.easeOut});
			
			width.addEvent('onComplete', function(e){
			
				show.start({
					'opacity': [0, 1]
				});
				
				hide.start({
					'opacity': [1, 0]
				});
			});
			
			show.addEvent('onComplete', function(e){
				
				panel_state = 'expanded';
			});
			
			width.start({
				'width': [24, 207]
			});
		}
	});
	
	new Accordion($('p-menu'), 'h2', 'div.pm-sub', {
		opacity: true,
		display: np_expanded,
		onActive: function(toggler, element){

			toggler.set('class', 'pm-active');
		},
		onBackground: function(toggler, element){
			
			toggler.set('class', '');
		}
	});

	
});
