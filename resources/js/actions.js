scrollbar_init('.box-left');

$('.vote-action').on('click', function() {
	
	const vote = new Vote;
	
	switch($(this).data('action')) {
		case 'up':
			vote.up($(this));
		break;
		
		case 'down':
			vote.down($(this));
		break;
	}
});
