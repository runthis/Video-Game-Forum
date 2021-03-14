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

@include('header.main')

<div class="row h-fill-100 mt-3">
	<div class="col box-left">
		<div class="thread-container pb-5">
			
			@include('post.entry')
			@include('post.edit')
			@include('post.actions')
			
			@if(Session::get('forum.user') && $post->lock == 0)
				@include('reply.new')
			@endif
			
			<div class="thread-all-replies">
				@foreach ($post->reply as $reply)
					@include('reply.entry')
					@include('reply.actions')
				@endforeach
			</div>
		</div>
	</div>
	
	<div class="col-3 d-none d-md-block box box-right ml-2 h-100">
		@include('header.right')
		@include('footer.right')
	</div>
</div>

@endsection
