<td class="thread-voting pl-3" valign="middle" width="40px">
	<div class="w-100 text-center">
		<span class="vote-action {{ (($post->vote->where('owner', Session::get('forum.user'))->firstWhere('vote', 1)) ? 'voted' : '') }}" data-type="post" data-action="up" data-id="{{ $post->id }}" data-url="{{ url('/upvotePost') }}" data-token="{{ csrf_token() }}">
			<i class="icon-upvote"></i>
		</span>
		
		<div class="vote-count">{{$post->vote->sum('vote')}}</div>
		
		<span class="vote-action {{ (($post->vote->where('owner', Session::get('forum.user'))->firstWhere('vote', -1)) ? 'voted' : '') }}" data-type="post" data-action="down" data-id="{{ $post->id }}" data-url="{{ url('/downvotePost') }}" data-token="{{ csrf_token() }}">
			<i class="icon-downvote"></i>
		</span>
	</div>
</td>
