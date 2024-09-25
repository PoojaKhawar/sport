<div class="flash-message">
    @if(Session::has('success'))
    	<p class="alert alert-success alert-dismissible fade show" role="alert">
    		{{ Session::get('success') }}
    		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
    		</button>
    	</p>
    	{{ Session::forget('success') }}
    @endif
    @if(Session::has('error'))
    	<p class="alert alert-danger alert-dismissible fade show" role="alert">
    		{{ Session::get('error') }}
    		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
    		</button>
    	</p>
    	{{ Session::forget('error') }}
    @endif
</div>