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
@section('og_image_width', 1200)
@section('og_image_height', 630)

@push('styles')
	<link href="{{ asset(mix('css/home.css')) }}" rel="stylesheet">
@endpush

@section('content')
	@include('header.main')

	<div class="row h-fill-100">
		<div class="col box-left">
			@foreach ($posts as $post)
				
				@section('reply.count')
					<td class="thread-meta pl-3 pr-3">
						<i class="icon-comments mr-1" data-id="{{$post['id']}}"></i> {{$post->reply->count()}}
					</td>
				@endsection
				
				@include('post.entry')
				
			@endforeach
			
			@include('includes.pagination')
		</div>
		
		<div class="col-3 d-none d-md-block box box-right ml-2 h-100">
			@include('header.right')
			@include('footer.right')
		</div>
	</div>
@endsection
