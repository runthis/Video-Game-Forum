@if(url()->current() == route('home'))
	<div class="forum-actions my-details mt-3">
		<h4 class="text-center">Trending Discussions</h4>
		
		<ul class="ml-3 pl-3 pr-3">
			<li><a class="thread-trending" href="/kjjhk">Are tomatoes a fruit or vegetable?</a></li>
			<li><a class="thread-trending" href="/hfgfgh">Why does a woodchuck even chuck wood, and why do we care how much wood the woodchuck can chuck?</a></li>
			<li><a class="thread-trending" href="/kjjhk">Has anyone tried the new update?</a></li>
			<li><a class="thread-trending" href="/kjjhk">Howwwwwwwwwwwwwwwwwwwwwwwwwww</a></li>
		</ul>
	</div>
@else
	<div class="forum-actions my-details">
		<a class="text-white" href="{{url('/?page=' . Session::get('forum.page'))}}">
			<div class="go-back p-2 text-white small">
				<i class="icon-left"></i> Go back to page {{Session::get('forum.page')}}
			</div>
		</a>
	</div>
@endif
