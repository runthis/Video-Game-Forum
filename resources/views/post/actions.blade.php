<div class="thread-article-actions mt-1">
	<table>
		<tr>
			<td>{{ $post->reply->count() }} comment{{ ($post->reply->count() == 1 ? '' : 's') }}</td>
			<td><span class="thread-action" data-action="share">share</span></td>
			
			@if( $post->lock == 0 && (Session::get('forum.user') == $post->owner || Session::get('forum.role') > 1))
			<td><span class="thread-action" data-action="edit">edit</span></td>
			<td><span class="thread-action" data-action="delete" data-post="{{ $post->id }}" data-url="{{ url('/deletePost') }}" data-token="{{ csrf_token() }}">delete</span></td>
			@endif
			
			@if(Session::get('forum.role') > 1)
			
			<!-- Staff: sticky post -->
			<td>
				<span class="thread-action" data-action="sticky" data-post="{{ $post->id }}" data-url="{{ url('/stickyPost') }}" data-token="{{ csrf_token() }}">
					@if($post->sticky == 0)
						sticky
					@else
						<span class="text-warning">unsticky</span>
					@endif
				</span>
			</td>
			
			<!-- Staff: lock post -->
			<td>
				<span class="thread-action" data-action="lock" data-post="{{ $post->id }}" data-url="{{ url('/lockPost') }}" data-token="{{ csrf_token() }}">
					@if($post->lock == 0)
						lock
					@else
						<span class="text-warning">unlock</span>
					@endif
				</span>
			</td>
			@endif
			
			@if(Session::get('forum.user'))
				<td><span class="thread-action" data-action="report" data-post="{{ $post->id }}" data-url="{{ url('/reportPost') }}" data-token="{{ csrf_token() }}">report</span></td>
			@endif
			
		</tr>
	</table>
</div>
