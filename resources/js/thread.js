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
	}
});
