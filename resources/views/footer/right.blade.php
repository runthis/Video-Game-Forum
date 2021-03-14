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
