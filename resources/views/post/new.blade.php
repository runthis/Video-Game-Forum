<form action="createPost" method="post">
	@csrf
	
	<input type="text" name="subject" class="comment-subject" placeholder="Enter a subject" maxlength="200" value="{{ old('subject') }}">
	@error('subject')
		<div class="text-warning m-2">{{ $message }}</div>
	@enderror
	
	<textarea name="body" class="comment-input mt-3" rows="12" placeholder="Type something here">{{ old('body') }}</textarea>
	@error('body')
		<div class="text-warning m-2">{{ $message }}</div>
	@enderror
	
	<div class="mb-5 mt-3">
		<button class="btn-dark">create post</button>
	</div>
</form>
