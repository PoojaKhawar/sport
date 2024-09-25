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
		{{ $row->url }}
	</td>
	<td>
		{{ $row->client ? $row->users_first_name . ' ' . $row->users_last_name : "" }}
	</td>
	<td>
		{{ ($row->admin ? $row->admin_first_name . ' ' . $row->admin_last_name : "") }}
	</td>
	<td>
		{{ ($row->method ? $row->method : '') }}
	</td>
	<td>
		{{ $row->ip }}
	</td>
	<td>
		{{ _dt($row->created_at) }}
	</td>
	<td class="text-right">
		<div class="action_dropdown btn-group">
			<a href="javascript:;" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-ellipsis-v"></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-end">
				<li>
					<a class="dropdown-item" href="{{ route('admin.activities.logView', ['id' => $row->id]) }}">
						<i class="fas fa-eye text-info"></i>
						<span class="status">View</span>
					</a>
				</li>
			</ul>
		</div>
	</td>
</tr>
@endforeach