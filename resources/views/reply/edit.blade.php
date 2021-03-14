<form class="thread-reply-edit" id="thread-reply-edit-{{$reply->id}}" action="{{ url('/editReply') }}" method="post">
	@csrf
	
	<textarea name="replyBody" class="comment-input" rows="8" placeholder="Type a comment here">{!! str_replace('<br />','',$reply->body) !!}</textarea>
	<input type="hidden" name="reply" value="{{ $reply->id }}">
	<input type="hidden" name="link" value="{{ $post->link }}">
	
	<div class="mt-1">
		<button class="btn-dark">edit reply</button>
	</div>
</form>
