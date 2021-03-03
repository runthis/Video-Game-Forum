@extends('layout')

@section('title', 'Home')

@section('content')

<form action="createPost" method="post">
	
	@csrf
	
	<div>
		<label for="subject">Subject</label>
		<input type="text" name="subject" id="subject" value="{{ old('subject') }}" placeholder="What is this about..." required>
	</div>
	
	<div>
		<label for="body">Body</label>
		<textarea name="body" id="body" placeholder="Tell us about it..." required>{{ old('body') }}</textarea>
	</div>
	
	<button type="submit">Submit</button>
</form>





@endsection
