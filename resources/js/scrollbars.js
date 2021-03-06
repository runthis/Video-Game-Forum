function scrollbar_init(element) {
	$(element).overlayScrollbars({
		className: 'os-theme-round-light',
		normalizeRTL: true,
		scrollbars: {
			clickScrolling: true
		},
		overflowBehavior: {
			x: 'h'
		}
	});
}
