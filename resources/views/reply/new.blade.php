<div class="thread-article mt-3">
	<form method="post">
		@csrf
		
		<textarea name="comment" class="comment-input" rows="5" placeholder="Type a comment here">{{ old('comment') }}</textarea>
		@error('comment')
			<div class="text-warning m-2">{{ $message }}</div>
		@enderror
		
		<input type="hidden" name="post" value="{{ $post->id }}">
		
		<div class="mt-1">
			<button class="btn-dark">add comment</button>
		</div>
	</form>
</div>
