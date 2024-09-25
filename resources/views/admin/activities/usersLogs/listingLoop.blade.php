@foreach($listing->items() as $k => $row)
<tr>
	<td>
		<!-- MAKE SURE THIS HAS ID CORRECT AND VALUES CORRENCT. THIS WILL EFFECT ON BULK CRUTIAL ACTIONS -->
		<div class="form-check">
        	<input type="checkbox" class="form-check-input listing_check" value="{{ $row->id }}" id="listing_check{{ $row->id }}">
        	<label class="form-check-label" for="listing_check{{ $row->id }}"></label>
      	</div>
	</td>
	<td>
		{{ $row->id }}
	</td>
	<td>
		{{ $row->ip }}
	</td>
	<td>
		{{ isset($row->users_first_name) && $row->users_first_name ? ($row->users_first_name) . ' ' . $row->users_last_name : '' }}
	</td>
	<td>
		@if(isset($row->location) && $row->location)
			@if(json_decode($row->location,true))
				@if(json_decode($row->location,true)['city'])
					@if(json_decode($row->location,true)['city']['name'])
						{{ json_decode($row->location,true)['city']['name']; }}
					@endif
				@endif
			@endif
		@endif
	</td>
	<td>
		{!! isset($row->type) && $row->type ? '<span class="badge bg-primary">'.ucfirst($row->type).'</span>' : '' !!}
	</td>
	
	<td>
		{{ isset($row->updated_at) && $row->updated_at ? (new DateTime($row->updated_at))->format('jS M, Y h:iA' ) : '' }}
	</td>
	
	<td class="text-right">
		<div class="action_dropdown btn-group">
			<a href="javascript:;" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-ellipsis-v"></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-end">
				<li>
					<a class="dropdown-item" href="{{ route('admin.activities.userView', ['id' => $row->id]) }}">
						<i class="fas fa-eye text-info"></i>
						<span class="status">View</span>
					</a>
				</li>
			</ul>
		</div>
	</td>
</tr>
@endforeach