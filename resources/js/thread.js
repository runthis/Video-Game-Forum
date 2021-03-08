scrollbar_init('.box-left');

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
	}
});
