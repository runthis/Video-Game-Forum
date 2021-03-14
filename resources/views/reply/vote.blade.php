<td class="thread-voting pl-3" valign="top" width="40px">
	<div class="w-100 text-center">
		<span class="vote-action {{ (($reply->vote->where('owner', Session::get('forum.user'))->firstWhere('vote', 1)) ? 'voted' : '') }}" data-type="reply" data-action="up" data-id="{{ $reply->id }}" data-url="{{ url('/upvoteReply') }}" data-token="{{ csrf_token() }}">
			<i class="icon-upvote"></i>
		</span>
		
		<div class="vote-count">{{$reply->vote->sum('vote')}}</div>
		
		<span class="vote-action {{ (($reply->vote->where('owner', Session::get('forum.user'))->firstWhere('vote', -1)) ? 'voted' : '') }}" data-type="reply" data-action="down" data-id="{{ $reply->id }}" data-url="{{ url('/downvoteReply') }}" data-token="{{ csrf_token() }}">
			<i class="icon-downvote"></i>
		</span>
	</div>
</td>
