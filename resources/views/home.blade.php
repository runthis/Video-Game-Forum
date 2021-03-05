@extends('layout')

@section('title', 'Home')

@push('styles')
	<link href="{{ asset(mix('css/home.css')) }}" rel="stylesheet">
@endpush


@section('content')

<div class="row hpx-100">
	<div class="col-8">
		<div class="logo mt-3">
			<h3><a class="text-white" href="{{url('/')}}">Game Forum</a></h3>
			<span class="text-muted">Your tagline here</span>
		</div>
	</div>
	<div class="col">
		<div class="forum-actions text-right mt-4">
			<a class="btn btn-dark" href="post">New Post</a>
		</div>
	</div>
</div>

<div class="row h-fill-100">

	<div class="col box-left">
		
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
					
					<td class="thread-meta pl-3 pr-3">
						<i class="icon-comments mr-1" data-id="thread-id"></i> 1,863
					</td>
				</tr>
				
				
				
			</table>
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
					
					<td class="thread-meta pl-3 pr-3">
						<i class="icon-comments mr-1" data-id="thread-id"></i> 1,863
					</td>
				</tr>
				
				
				
			</table>
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
					
					<td class="thread-meta pl-3 pr-3">
						<i class="icon-comments mr-1" data-id="thread-id"></i> 1,863
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
								<div class="vote-count" data-id="thread-id">2</div>
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
									Normal Thread With long wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
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
					
					<td class="thread-meta pl-3 pr-3">
						<i class="icon-comments mr-1" data-id="thread-id"></i> 12
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
								<div class="vote-count" data-id="thread-id">2</div>
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
									Normal Thread With long wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
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
					
					<td class="thread-meta pl-3 pr-3">
						<i class="icon-comments mr-1" data-id="thread-id"></i> 12
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
								<div class="vote-count" data-id="thread-id">2</div>
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
									Normal Thread With long wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
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
					
					<td class="thread-meta pl-3 pr-3">
						<i class="icon-comments mr-1" data-id="thread-id"></i> 12
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
								<div class="vote-count" data-id="thread-id">2</div>
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
									Normal Thread With long wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
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
					
					<td class="thread-meta pl-3 pr-3">
						<i class="icon-comments mr-1" data-id="thread-id"></i> 12
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
		
		<div class="forum-actions my-details mt-3">
			
			<h4 class="text-center">Trending Discussions</h4>
			
			<ul class="ml-3 pl-3 pr-3">
				<li><a class="thread-trending" href="/kjjhk">Are tomatoes a fruit or vegetable?</a></li>
				<li><a class="thread-trending" href="/hfgfgh">Why does a woodchuck even chuck wood, and why do we care how much wood the woodchuck can chuck?</a></li>
				<li><a class="thread-trending" href="/kjjhk">Has anyone tried the new update?</a></li>
				<li><a class="thread-trending" href="/kjjhk">Howwwwwwwwwwwwwwwwwwwwwwwwwww</a></li>
			</ul>
			
			
			
		</div>
		
		<div class="logo-container">
			<div class="logo mb-3 text-center">
				<small class="text-muted">v0.01</small>
			</div>
		</div>
	</div>
</div>

@endsection
