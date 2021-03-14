<div class="thread {{$post['sticky'] ? 'thread-sticky' : ''}}">
	<table class="w-100 h-100">
		<tr>
			@include('post.vote')
			
			<td class="thread-avatar pl-3  pt-2 d-none d-md-table-cell" valign="top">
				<img class="w-100" src="{{ asset('img/avatars/default.png') }}">
			</td>
			
			<td class="pl-4  pt-2" valign="top">
				<div class="thread-content mt-1">
					<div class="thread-title">
						<a href="{{ url('thread/' . $post->link) }}">
							{{ ($post->lock == 0 ? '' : '🔒') }} {{$post->subject}}
						</a>
					</div>
					
					<div class="thread-details">
						{{$post->created_at->diffForHumans()}}
						<div class="thread-author">
							{{$post->user->name}}
						</div>
					</div>
				</div>
			</td>
			
			@yield('reply.count')
		</tr>
	</table>
</div>
