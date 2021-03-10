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
		case 'edit':
			$('#thread-main').toggle();
			$('#thread-main-edit').toggle();
		break;
		
		case 'delete':
			$.post($(this).data('url'), {post: $(this).data('post'), _token: $(this).data('token')}, function() {
				$('.go-back').click();
			});
		break;
		
		case 'editReply':
			$('#thread-reply-' + $(this).data('reply')).toggle();
			$('#thread-reply-edit-' + $(this).data('reply')).toggle();
		break;
	}
});
