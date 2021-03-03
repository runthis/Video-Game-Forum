@extends('layout')

@section('title', 'Login')

@section('content')
<div>
	<h3>Login User</h3>
	
	@if(Session::get('error'))
		<div>{{Session::get('error')}}</div>
	@endif
	
	<form action="loginUser" method="post">
		
		@csrf
		
		<div>
			<label for="email">Email</label>
			<input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter Email" required>
		</div>
		
		@error('email')
			<div>{{ $message }}</div>
		@enderror
		
		<div>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" placeholder="Enter Password" required>
		</div>
		
		@error('password')
			<div>{{ $message }}</div>
		@enderror
		
		<button type="submit">Submit</button>
	</form>
</div>
@endsection
