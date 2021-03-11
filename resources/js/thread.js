scrollbar_init('.box-left');

let hash = window.location.hash;

// If a specific thread reply is sent in the hash
// Scroll to the reply and add some style to it
if( $(hash).length ) {
	$(hash).get(0).scrollIntoView();
	$(hash).closest('.thread-article').addClass('thread-reply-active');
}

$('.thread-action').on('click', function() {
	switch($(this).data('action')) {
		
		// Posts
		case 'edit':
			$('#thread-main').toggle();
			$('#thread-main-edit').toggle();
		break;
		
		case 'delete':
			$.post($(this).data('url'), {post: $(this).data('post'), _token: $(this).data('token')}, function() {
				$('.go-back').click();
			});
		break;
		
		case 'sticky':
			var original = $(this);
			$.post($(this).data('url'), {post: $(this).data('post'), _token: $(this).data('token')}, function() {
				if( original.text().trim() == 'sticky' ) {
					original.html('<span class="text-warning">unsticky</span>');
				} else {
					original.text('sticky');
				}
			});
		break;
		
		case 'lock':
			var original = $(this);
			$.post($(this).data('url'), {post: $(this).data('post'), _token: $(this).data('token')}, function() {
				window.location.reload();
			});
		break;
		
		case 'report':
			var original = $(this);
			$.post($(this).data('url'), {post: $(this).data('post'), _token: $(this).data('token')}, function() {
				original.parent().html('<span class="text-warning">reported</span>');
			});
		break;
		
		
		
		// Replies
		case 'editReply':
			$('#thread-reply-' + $(this).data('reply')).toggle();
			$('#thread-reply-edit-' + $(this).data('reply')).toggle();
		break;
		
		case 'deleteReply':
			$.post($(this).data('url'), {reply: $(this).data('reply'), _token: $(this).data('token')}, function() {
				window.location.reload();
			});
		break;
		
		case 'stickyReply':
			var original = $(this);
			$.post($(this).data('url'), {reply: $(this).data('reply'), _token: $(this).data('token')}, function() {
				if( original.text().trim() == 'sticky' ) {
					let actions = original.closest('.thread-article-actions');
					
					original.html('<span class="text-warning">unsticky</span>');
					
					actions.prev().addClass('thread-reply-sticky');
					actions.prev().prependTo('.thread-all-replies');
					
					$('.thread-all-replies .thread-article:first-child').after(actions);
				} else {
					let actions = original.closest('.thread-article-actions');
					
					original.text('sticky');
					
					actions.prev().removeClass('thread-reply-sticky');
					actions.prev().appendTo('.thread-all-replies');
					
					$('.thread-all-replies .thread-article:last-child').after(actions);
				}
			});
		break;
		
		case 'reportReply':
			var original = $(this);
			$.post($(this).data('url'), {reply: $(this).data('reply'), _token: $(this).data('token')}, function() {
				original.parent().html('<span class="text-warning">reported</span>');
			});
		break;
	}
});
