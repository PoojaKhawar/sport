<div class="modal-body">
    <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Id</th>
                    <td>{{ $row->id }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $row->email }}</td>
                </tr>
                <tr>
                    <th>Created On</th>
                    <td>{{ _dt($row->created_at) }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        {!! $row->status ? '<span class="badge bg-success">Publish</span>' : '<span class="badge bg-danger">Unpublish</span>' !!}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>