scrollbar_init('.box-left');

$('.home-action').on('click', function() {
	switch($(this).data('action')) {
		
		case 'upvotePost':
			var original = $(this);
			$.post($(this).data('url'), {post: $(this).data('post'), _token: $(this).data('token')}, function( $data ) {
				original.closest('.thread-voting').find('.voted').removeClass('voted');
				original.next().text($data['votes']);
				
				switch($data['status']) {
					case 'deleted':
						original.removeClass('voted');
					break;
					case 'created':
						original.addClass('voted');
					break;
				}
			});
		break;
		
		case 'downvotePost':
			var original = $(this);
			$.post($(this).data('url'), {post: $(this).data('post'), _token: $(this).data('token')}, function( $data ) {
				original.closest('.thread-voting').find('.voted').removeClass('voted');
				original.prev().text($data['votes']);
				
				switch($data['status']) {
					case 'deleted':
						original.removeClass('voted');
					break;
					case 'created':
						original.addClass('voted');
					break;
				}
			});
		break;
	}
});
