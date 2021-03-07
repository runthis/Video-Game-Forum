@extends('layout')

@section('title', 'Home')
@section('description', 'Video Game - Forum')
@section('og_url', url('/'))
@section('og_article_author', 'Video Game')
@section('og_article_publisher', 'Video Game')
@section('og_title', 'Video Game - Forum')
@section('og_description', 'Video Game - Forum')
@section('og_image', url('/img/seoimage.png'))
@section('og_image_alt', url('/img/seoimage.png'))
@section('og_image_width', 53)
@section('og_image_height', 50)

@push('styles')
	<link href="{{ asset(mix('css/home.css')) }}" rel="stylesheet">
@endpush

@section('content')

<div class="row hpx-100">
	<div class="col-8">
		<div class="logo mt-3">
			<h3><a class="text-white" href="{{url('/')}}">Game Forum</a></h3>
			<span class="text-muted">Your tagline here</span>
		</div>
	</div>
	<div class="col">
		<div class="forum-actions text-right mt-4">
			<a class="btn btn-dark" href="post">New Post</a>
		</div>
	</div>
</div>

<div class="row h-fill-100">

	<div class="col box-left">
		
		@foreach ($posts as $post)
		
		<div class="thread {{$post['sticky'] ? 'thread-sticky' : ''}}">
			<table class="w-100 h-100">
				<tr>
					<td class="thread-voting pl-3 pt-3" valign="top">
						<div class="w-100 text-center">
							<i class="icon-upvote" data-id="{{$post['id']}}"></i>
							<div class="vote-count" data-id="{{$post['id']}}">9</div>
							<i class="icon-downvote" data-id="{{$post['id']}}"></i>
						</div>
					</td>
					
					<td class="thread-avatar pl-3  pt-2 d-none d-md-table-cell" valign="top">
						<img class="w-100" src="{{ asset('img/avatars/default.png') }}">
					</td>
					
					<td class="pl-4  pt-2" valign="top">
						<div class="thread-content mt-1">
							<div class="thread-title">
								<a href="thread/{{$post->link}}/">
									{{$post->subject}}
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
					
					<td class="thread-meta pl-3 pr-3">
						<i class="icon-comments mr-1" data-id="{{$post['id']}}"></i> {{$post->reply->count()}}
					</td>
				</tr>
			</table>
		</div>
		
		@endforeach
		
		<!-- Pagination -->
		<div class="mt-3 text-center">
			@if ($page < $pages)
				<a href="?page={{($page + 1)}}" class="btn btn-sm btn-dark">Next</a>
			@endif
			
			@for ($i = ($page + 3); $i >= ($page - 3); $i--)
				@if ($i < 1)
					@continue
				@endif
				
				@if ($i > $pages)
					@continue
				@endif
				
				@if ($i == $page)
					<a class="btn btn-sm btn-dark btn-paginate-active">{{$i}}</a>
				@else
					<a href="?page={{$i}}" class="btn btn-sm btn-dark btn-paginate">{{$i}}</a>
				@endif
			@endfor
			
			@if ($page > 1)
				<a href="?page={{($page - 1)}}" class="btn btn-sm btn-dark">Previous</a>
			@endif
		</div><!-- /Pagination -->
		
	</div>
	
	<div class="col-3 d-none d-md-block box box-right ml-2 h-100">
		<div class="forum-actions my-details mt-3">
			<h4 class="text-center">Trending Discussions</h4>
			
			<ul class="ml-3 pl-3 pr-3">
				<li><a class="thread-trending" href="/kjjhk">Are tomatoes a fruit or vegetable?</a></li>
				<li><a class="thread-trending" href="/hfgfgh">Why does a woodchuck even chuck wood, and why do we care how much wood the woodchuck can chuck?</a></li>
				<li><a class="thread-trending" href="/kjjhk">Has anyone tried the new update?</a></li>
				<li><a class="thread-trending" href="/kjjhk">Howwwwwwwwwwwwwwwwwwwwwwwwwww</a></li>
			</ul>
		</div>
		
		<div class="logo-container">
			<div class="logo mb-3 text-center">
				@if(!Session::get('forum.user'))
					<a class="text-warning" href="login">Login</a> / <a class="text-warning" href="register">Register</a>
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
	<script src="{{ asset(mix('js/home.js')) }}"></script>
@endpush
