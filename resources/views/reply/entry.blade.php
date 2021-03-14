<div class="thread-article mt-3 {{ ($reply->sticky == 0 ? '' : 'thread-reply-sticky') }}">

	<table class="thread-reply-container">
		<tr>
			@include('reply.vote')
			
			<td valign="top" width="100%">
				<div class="ml-2">

					<img class="mb-2" style="max-height: 20px;width: 15px;" src="{{ asset('img/avatars/default.png') }}">

					<span class="thread-author">{{$reply->user->name}}</span>
					<span class="thread-reply-details ml-3">{{$reply->created_at->diffForHumans()}}</span>
					
					@if(Session::get('last_reply_edit') == $reply->id)
						@error('replyBody')
							<div class="text-warning mb-4">Edit Error: {{ $message }} Please try to edit the reply again.</div>
						@enderror
					@endif
					
					<div class="thread-reply mt-2" id="thread-reply-{{$reply->id}}">
						{!! $reply->body !!}
					</div>
					
					@if(Session::get('forum.user') == $reply->owner || Session::get('forum.role') > 1)
						@include('reply.edit')
					@endif
				</div>
			</td>
		</tr>
	</table>
</div>