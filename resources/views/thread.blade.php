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
								<span class="thread-action {{ (($post->vote->where('owner', Session::get('forum.user'))->firstWhere('vote', 1)) ? 'voted' : '') }}" data-action="upvote" data-post="{{ $post->id }}" data-url="{{ url('/upvotePost') }}" data-token="{{ csrf_token() }}">
									<i class="icon-upvote"></i>
								</span>
								
								<div class="vote-count">{{$post->vote->sum('vote')}}</div>
								
								<span class="thread-action {{ (($post->vote->where('owner', Session::get('forum.user'))->firstWhere('vote', -1)) ? 'voted' : '') }}" data-action="downvote" data-post="{{ $post->id }}" data-url="{{ url('/downvotePost') }}" data-token="{{ csrf_token() }}">
									<i class="icon-downvote"></i>
								</span>
							</center>
						</div>
					</td>


					<td valign="top" class="thread-avatar pl-3" valign="top">
						<img class="w-100 mt-2 mb-2" src="{{ asset('img/avatars/default.png') }}">
					</td>


					<td class="pl-4 pt-2" valign="top">

						<div class="thread-content">
							<div class="thread-title">
								<a href="">{{ ($post->lock == 0 ? '' : '🔒') }} {{$post->subject}}</a>
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
			
			@if(Session::get('forum.user') && $post->lock == 0)
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
			
			<div class="thread-all-replies">
				@foreach ($post->reply as $reply)
				<div class="thread-article mt-3 {{ ($reply->sticky == 0 ? '' : 'thread-reply-sticky') }}">
				
					<table class="thread-reply-container">
						<tr>
							<td valign="top" class="thread-reply-voting" >
								<center>
									<span class="thread-action {{ (($reply->vote->where('owner', Session::get('forum.user'))->firstWhere('vote', 1)) ? 'voted' : '') }}" data-action="upvoteReply" data-reply="{{ $reply->id }}" data-url="{{ url('/upvoteReply') }}" data-token="{{ csrf_token() }}">
										<i class="icon-upvote"></i>
									</span>
									
									<div class="vote-count">{{$reply->vote->sum('vote')}}</div>
									
									<span class="thread-action {{ (($reply->vote->where('owner', Session::get('forum.user'))->firstWhere('vote', -1)) ? 'voted' : '') }}" data-action="downvoteReply" data-reply="{{ $reply->id }}" data-url="{{ url('/downvoteReply') }}" data-token="{{ csrf_token() }}">
										<i class="icon-downvote"></i>
									</span>
								</center>
							</td>
							
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
									<form class="thread-reply-edit" id="thread-reply-edit-{{$reply->id}}" action="{{ url('/editReply') }}" method="post">
										@csrf
										
										<textarea name="replyBody" class="comment-input" rows="8" placeholder="Type a comment here">{!! str_replace('<br />','',$reply->body) !!}</textarea>
										<input type="hidden" name="reply" value="{{ $reply->id }}">
										<input type="hidden" name="link" value="{{ $post->link }}">
										
										<div class="mt-1">
											<button class="btn-dark">edit reply</button>
										</div>
									</form>
									@endif
									
								</div>
							</td>
						</tr>
					</table>
				</div>
				
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
				
				@endforeach
			</div>
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
