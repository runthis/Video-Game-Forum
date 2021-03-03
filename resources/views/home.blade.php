@extends('layout')

@section('title', 'Home')

@push('styles')
	<link href="{{ asset(mix('css/all.css')) }}" rel="stylesheet">
@endpush


@section('content')

<div class="row h-100">

	<div class="col box-left">
		
		<!-- Spacer -->
		<div class="d-block d-sm-none" style="height: 75px;">
			<div class="forum-actions pt-3 text-center">
				<a class="btn btn-dark" href="post">Create Post</a>
			</div>
		</div>
		
		<div class="thread thread-sticky ">
			<table class="w-100 h-100">
			
			
			
				<tr>
					<td class="thread-voting pl-3">
						<div class="w-100">
							<center>
								<i class="icon-upvote" data-id="thread-id"></i>
								<div class="vote-count" data-id="thread-id">9</div>
								<i class="icon-downvote" data-id="thread-id"></i>
							</center>
						</div>
					</td>
					
					<td class="thread-avatar pl-3">
						<img class="w-100" style="" src="{{ asset('img/avatars/default-avatar.png') }}">
					</td>
					
					<td class="pl-4 pt-2" valign="top">
						<div class="thread-content">
							<div class="thread-title">
								<a href="thread/name-here">
									<font color="yellow">Stickied Thread</font>
								</a>
							</div>
							
							<div class="thread-details">
								<div>3 weeks ago</div>
								
								<span class="thread-author">
									Username											
								</span>
							</div>
						</div>
					</td>
				</tr>
				
				
				
			</table>
		</div>
				
		<div class="thread">
			
			<table class="w-100 h-100">
				
				
				
				<tr>
					<td class="thread-voting pl-3">
						<div class="w-100">
							<center>
								<i class="icon-upvote" data-id="thread-id"></i>
								<div class="vote-count" data-id="thread-id">9</div>
								<i class="icon-downvote" data-id="thread-id"></i>
							</center>
						</div>
					</td>
					
					<td class="thread-avatar pl-3">
						<img class="w-100" style="" src="{{ asset('img/avatars/default-avatar.png') }}">
					</td>
					
					<td class="pl-4 pt-2" valign="top">
						<div class="thread-content">
							<div class="thread-title">
								<a href="thread/name-here">
									Normal Thread
								</a>
							</div>
							
							<div class="thread-details">
								<div>2 days ago</div>
								
								<span class="thread-author">
									Username											
								</span>
							</div>
						</div>
					</td>
				</tr>
				
				
				
			</table>
			
		</div>
		
		
		<div style="height: 40px;"></div>

		<center>
			<a href="page/?page=2" class="btn btn-sm btn-dark btn-paginate">Next</a>
			<a href="page/?page=7" class="btn btn-sm btn-dark btn-paginate">7</a>
			<a href="page/?page=6" class="btn btn-sm btn-dark btn-paginate">6</a>
			<a href="page/?page=5" class="btn btn-sm btn-dark btn-paginate">5</a>
			<a href="page/?page=4" class="btn btn-sm btn-dark btn-paginate">4</a>
			<a href="page/?page=3" class="btn btn-sm btn-dark btn-paginate">3</a>
			<a href="page/?page=2" class="btn btn-sm btn-dark btn-paginate">2</a>
			<a class="btn btn-sm btn-dark btn-paginate btn-paginate-active">1</a>
		</center>
		
		<div style="height: 50px;"></div>
		
	</div>
	
	<div class="col-3 d-none d-sm-block box box-right ml-2 h-100">
		<div class="forum-actions text-center mt-5">
			<a class="btn btn-dark" href="post">Create Post</a>
		</div>
		
		<div class="logo-container">
			<div class="logo mb-3 text-center">
				<span>Forum</span> <small class="text-muted">v0.01</small>
			</div>
		</div>
	</div>
</div>

@endsection
