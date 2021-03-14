<div class="thread-article-actions mt-1">
	<table>
		<tr>
			@if($post->lock == 0 && (Session::get('forum.user') == $reply->owner || Session::get('forum.role') > 1))
			<td><span class="thread-action" data-action="editReply" data-reply="{{ $reply->id }}">edit</span></td>
			<td><span class="thread-action" data-action="deleteReply" data-reply="{{ $reply->id }}" data-url="{{ url('/deleteReply') }}" data-token="{{ csrf_token() }}">delete</span></td>
			@endif
			
			@if(Session::get('forum.user') == $post->owner || Session::get('forum.role') > 1)
			<td>
				<span class="thread-action" data-action="stickyReply" data-reply="{{ $reply->id }}" data-url="{{ url('/stickyReply') }}" data-token="{{ csrf_token() }}">
					@if($reply->sticky == 0)
						sticky
					@else
						<span class="text-warning">unsticky</span>
					@endif
				</span>
			</td>
			@endif
		
			@if(Session::get('forum.user'))
				<td><span class="thread-action" data-action="reportReply" data-reply="{{ $reply->id }}" data-url="{{ url('/reportReply') }}" data-token="{{ csrf_token() }}">report</span></td>
			@endif
		</tr>
	</table>
</div>
