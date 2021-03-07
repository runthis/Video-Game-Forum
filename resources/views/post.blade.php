@extends('layout')

@section('title', 'New Post')

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
		<div class="thread" style="direction: ltr;">
			<div class="thread-container">
					
				<div class="thread-article mt-4">
					
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
				</div>
				<div style="height: 90px;">&nbsp;</div>
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
				<div class="text-muted">v0.01</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
	<script src="{{ asset(mix('js/home.js')) }}"></script>
@endpush
