<br>
@if(Session::has('success'))
<div class="alert alert-success">
	<div class="container">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<i class="nc-icon nc-simple-remove"></i>
		</button>
		<span>{{ Session::pull('success') }}</span>
	</div>
</div>
@endif
@if(Session::has('info'))
<div class="alert alert-info">
	<div class="container">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<i class="nc-icon nc-simple-remove"></i>
		</button>
		<span>{{ Session::pull('info') }}</span>
	</div>
</div>
@endif
@if(Session::has('danger'))
<div class="alert alert-danger">
	<div class="container">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<i class="nc-icon nc-simple-remove"></i>
		</button>
		<span>{{ Session::pull('danger') }}</span>
	</div>
</div>
@endif
@if(Session::has('warning'))
<div class="alert alert-warning">
	<div class="container">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<i class="nc-icon nc-simple-remove"></i>
		</button>
		<span>{{ Session::pull('warning') }}</span>
	</div>
</div>
@endif
