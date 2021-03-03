@extends('layout')

@section('title', 'Home')

@section('content')

<form action="createPost" method="post">
	
	@csrf
	
	<div>
		<label for="subject">Subject</label>
		<input type="text" name="subject" id="subject" value="{{ old('subject') }}" placeholder="Enter Email" required>
	</div>
	
	<div>
		<label for="body">Body</label>
		<textarea id="body" required>{{ old('body') }}</textarea>
	</div>
	
	<button type="submit">Submit</button>
</form>





@endsection
