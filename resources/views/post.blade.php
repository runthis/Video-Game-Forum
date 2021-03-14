@extends('layout')

@section('title', 'New Post')

@push('styles')
	<link href="{{ asset(mix('css/thread.css')) }}" rel="stylesheet">
@endpush

@section('content')

@include('header.main')

<div class="row h-fill-100 mt-3">
	<div class="col box-left">
		<div class="thread" style="direction: ltr;">
			<div class="thread-container">
				<div class="thread-article mt-4">
					@include('post.new')
				</div>
				<div style="height: 90px;">&nbsp;</div>
			</div>
		</div>
	</div>

	<div class="col-3 d-none d-md-block box box-right ml-2 h-100">
		@include('header.right')
		@include('footer.right')
	</div>
</div>

@endsection

@push('scripts')
	<script src="{{ asset(mix('js/home.js')) }}"></script>
@endpush
