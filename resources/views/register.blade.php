@extends('layout')

@section('content')
<div>
	<h3>Register User</h3>
	
	@if(Session::get('register_status'))
	<div>
		{{Session::get('register_status')}}
	</div>
	@endif
	
	<form action="registerUser" method="post" return="false">
		<div>
			<label for="name">Name</label>
			<input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter Name" required>
		</div>
		
		@error('name')
			<div>{{ $message }}</div>
		@enderror
		
		@csrf
		
		<div>
			<label for="email">Email</label>
			<input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="Enter Email" required>
		</div>
		
		@error('email')
			<div>{{ $message }}</div>
		@enderror
		
		<div>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" value="{{ old('password') }}" placeholder="Enter Password" required>
		</div>
		
		@error('password')
			<div>{{ $message }}</div>
		@enderror
		
		<div>
			<label for="confirm_password">Confirm Password</label>
			<input type="password" name="confirm_password" id="confirm_password" value="{{ old('confirm_password') }}" placeholder="Confirm Password" required>
		</div>
		
		@error('confirm_password')
			<div>{{ $message }}</div>
		@enderror
		
		<button type="submit">Submit</button>
	</form>
</div>
@endsection
