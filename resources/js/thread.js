scrollbar_init('.box-left');

$('.thread-action').on('click', function() {
	switch($(this).data('action')) {
		case 'edit':
			$('#thread-main').toggle();
			$('#thread-main-edit').toggle();
		break;
	}
});
