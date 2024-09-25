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
		{{ $row->to }}
	</td>
	<td>
		{{ $row->subject }}
	</td>
	{{-- <td>
		{{ ($row->cc }}
	</td> --}}
	<td>
		{!! $row->sent ? '<span class="badge bg-success">SENT</span>' : '<span class="badge bg-danger">NOT SENT</span>' !!}
	</td>
	{{-- <td>
		{{ ($row->open ? $row->open : '') }}
	</td> --}}
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
					<a class="dropdown-item" href="{{ route('admin.activities.emailView', ['id' => $row->id]) }}">
						<i class="fas fa-eye text-info"></i>
						<span class="status">View</span>
					</a>
				</li>
			</ul>
		</div>
	</td>
</tr>
@endforeach