@extends('layout')

@section('title', substr(html_entity_decode($post->subject, ENT_QUOTES), 0, 57) . '...')
@section('description', substr(html_entity_decode($post->subject, ENT_QUOTES), 0, 157) . '...')
@section('og_url', url('/thread/' . $post->link))
@section('og_article_author', $post->user->name)
@section('og_article_publisher', $post->user->name)
@section('og_title', substr(html_entity_decode($post->subject, ENT_QUOTES), 0, 57) . '...')
@section('og_description', substr(html_entity_decode(explode('<',$post->body)[0], ENT_QUOTES), 0, 157) . '...')
@section('og_image', url('/img/seoimage.png'))
@section('og_image_alt', url('/img/seoimage.png'))
@section('og_image_width', 1200)
@section('og_image_height', 630)

@push('styles')
	<link href="{{ asset(mix('css/thread.css')) }}" rel="stylesheet">
@endpush

@section('content')

<div class="row hpx-100">
	<div class="col-8">
		<div class="logo mt-3">
			<h3><a class="text-white" href="{{url('/')}}">Game Forum</a></h3>
			<span class="text-muted">Your tagline here</span>
		</div>
	</div>
</div>

<div class="row h-fill-100 mt-3">

	<div class="col box-left">
	
		<div class="thread-container pb-5">
			<table class="w-100 thread-container-header">
				
				<tr>
					<td valign="top" class="thread-voting pl-3 pt-2" valign="top">
						<div class="w-100 mt-1">
							<center>
								<i class="icon-upvote"></i>

								<div class="vote-count vote-count-main">2</div>

								<i class="icon-downvote"></i>
							</center>
						</div>
					</td>


					<td valign="top" class="thread-avatar pl-3" valign="top">
						<img class="w-100 mt-2 mb-2" src="{{ asset('img/avatars/default.png') }}">
					</td>


					<td class="pl-4 pt-2" valign="top">

						<div class="thread-content">
							<div class="thread-title">
								<a href="">{{$post->subject}}</a>
							</div>

							<div class="thread-details">
								{{$post->created_at->diffForHumans()}}<br><span class="thread-author">{{$post->user->name}}</span>
							</div>
						</div>
					</td>
				</tr>
			</table>
			
			
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
			
			<div class="thread-article-actions mt-1">
				<table>
					<tr>
						<td>{{$post->reply->count()}} comments</td>
						<td><span class="thread-action" data-action="share">share</span></td>
						
						@if(Session::get('forum.user') == $post->owner || Session::get('forum.role') > 1)
						<td><span class="thread-action" data-action="edit">edit</span></td>
						<td><span class="thread-action" data-action="delete" data-post="{{ $post->id }}" data-url="{{ url('/deletePost') }}" data-token="{{ csrf_token() }}">delete</span></td>
						@endif
					</tr>
				</table>
			</div>
			
			@if(Session::get('forum.user'))
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
			@endif
			
			@foreach ($post->reply as $reply)
			<div class="thread-article mt-3">
			
				<table class="thread-reply-container">
					<tr>
						<td valign="top">
							<center>
								<i class="icon-upvote icon-upvote-reply" data-id="2207"></i>
								<div class="vote-count" data-id="2207">2</div>
								<i class="icon-downvote icon-downvote-reply" data-id="2207"></i>
							</center>
						</td>
						
						<td valign="top">
							<div class="ml-2">

								<img class="mb-2" style="max-height: 20px;width: 15px;" src="{{ asset('img/avatars/default.png') }}">

								<span class="thread-author">{{$reply->user->name}}</span>
								
								<span class="thread-reply-details ml-3">
									{{$reply->created_at->diffForHumans()}}
								</span>
								<div class="edit-reply-input" id="edit-2207">
									<textarea class="comment-edit-input" rows="8" placeholder="Type something here"></textarea>

									<div class="mt-1 mb-5">
										<button class="comment-edit-save btn-dark" data-id="2207">
											save edit
										</button>
										<button class="comment-edit-cancel btn-dark" data-id="2207">
											cancel edit
										</button>
									</div>
								</div>
								
								<div class="thread-reply mt-2" id="reply-2207">
									{!! $reply->body !!}
								</div>
								
							</div>
						</td>
					</tr>
				</table>
			</div>
			
			@endforeach
		</div>
	</div>
	
	<div class="col-3 d-none d-md-block box box-right ml-2 h-100">
		
		<div class="forum-actions my-details">
			<a class="text-white" href="{{url('/?page=' . Session::get('forum.page'))}}">
				<div class="go-back p-2 text-white small">
					<i class="icon-left"></i> Go back to page {{Session::get('forum.page')}}
				</div>
			</a>
		</div>
		
		<div class="logo-container">
			<div class="logo mb-3 text-center">
				
				@if(!Session::get('forum.user'))
					<a class="text-warning" href="{{url('/login')}}">Login</a> / <a class="text-warning" href="{{url('/register')}}">Register</a>
				@endif
				
				@if(Session::get('forum.user'))
					<small>{{Session::get('forum.name')}}</small>
				@endif
				
				<div class="text-muted">v0.01</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
	<script src="{{ asset(mix('js/thread.js')) }}"></script>
@endpush
