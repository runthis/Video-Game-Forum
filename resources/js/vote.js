class Vote {
	
	up(element) {
		var self = this;
		let post_data = {
			_token: element.data('token')
		};
		
		post_data[element.data('type').trim()] = element.data('id');
		
		$.post(element.data('url'), post_data, function(return_data) {
			element.next().text(return_data['votes']);
			self.visuals(element.data('type').trim(), element, return_data);
		});
	}
	
	down(element) {
		var self = this;
		let post_data = {
			_token: element.data('token')
		};
		
		post_data[element.data('type').trim()] = element.data('id');
		
		$.post(element.data('url'), post_data, function(return_data) {
			element.prev().text(return_data['votes']);
			self.visuals(element.data('type').trim(), element, return_data);
		});
	}
	
	visuals(type, element, data) {
		element.closest('.thread-voting').find('.voted').removeClass('voted');
		
		switch(data['status']) {
			case 'deleted':
				element.removeClass('voted');
			break;
			case 'created':
				element.addClass('voted');
			break;
		}
	}
}
