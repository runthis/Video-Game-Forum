<div class="thread-article mt-3">
	
	@error('body')
		<div class="text-warning mb-4">Edit Error: {{ $message }} Please try to edit the post again.</div>
	@enderror
	
	<div id="thread-main">{!! $post->body !!}</div>
	
	@if(Session::get('forum.user') == $post->owner || Session::get('forum.role') > 1)
	<form id="thread-main-edit" action="{{ url('/editPost') }}" method="post">
		@csrf
		
		<textarea name="body" class="comment-input" rows="15" placeholder="Type a comment here">{!! str_replace('<br />','',$post->body) !!}</textarea>
		<input type="hidden" name="post" value="{{ $post->id }}">
		<input type="hidden" name="link" value="{{ $post->link }}">
		
		<div class="mt-1">
			<button class="btn-dark">edit post</button>
		</div>
	</form>
	@endif
	
</div>
