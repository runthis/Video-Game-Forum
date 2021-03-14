<div class="mt-3 text-center">
	@if ($page < $pages)
		<a href="?page={{($page + 1)}}" class="btn btn-sm btn-dark">Next</a>
	@endif
	
	@for ($i = ($page + 3); $i >= ($page - 3); $i--)
		@if ($i < 1)
			@continue
		@endif
		
		@if ($i > $pages)
			@continue
		@endif
		
		@if ($i == $page)
			<a class="btn btn-sm btn-dark btn-paginate-active">{{$i}}</a>
		@else
			<a href="?page={{$i}}" class="btn btn-sm btn-dark btn-paginate">{{$i}}</a>
		@endif
	@endfor
	
	@if ($page > 1)
		<a href="?page={{($page - 1)}}" class="btn btn-sm btn-dark">Previous</a>
	@endif
</div>
