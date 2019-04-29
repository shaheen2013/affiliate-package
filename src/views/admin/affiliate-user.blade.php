@extends('admin.master')

@section('title')
    Admin | News and update
@endsection

@section('breadcrumbs')
    <li>Affiliate and update</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mt-5">
        <h3 class="col-sm-12 text-center">{{ Session::get('success') ?:'' }}</h3>
        <div class="box">
            <div class="box-body">
                <h4 class="header-title">{{ $title }} list</h4>
                <div class="data-tables">
                    <table id="dataTable" class="table table-hover w-100">
                        <thead class="bg-light text-capitalize">
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Promotion Message</th>
                            <th>Website URL</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $val)
                        <tr>
                            <td>{{ $val->user->name }} {{ $val->user->last_name }}</td>
                            <td>{{ $val->user->username }}</td>
                            <td>{{ $val->user->email }}</td>
                            <td>{{ $val->promotion_message }}</td>
                            <td>{{ $val->website_url }}</td>
                            <td>
                                @if($val->status=='Approved')
                                    {{ $val->status }}<br>
                                    <strong>Code:</strong> {{ $val->affiliate_code }}, {{ $val->commission }}% Commission with {{ $val->use_limit }} Using Limit
                                    @if($val->user_code!='')
                                        <br><strong>User Code:</strong> {{ $val->user_code }}
                                    @endif
                                @else
                                    {{ $val->status }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if($val->status=='Approved')
                                <a href="{{ url('admin/affiliate', $val->id) }}">Details</a> |
                                <a href="#" onclick="affiliateReject('{{ url('admin/affiliate', $val->id) }}/rejected')">Reject</a> |
                                <a href="#" onclick="affiliateDelete('{{ url('admin/affiliate', $val->id) }}/delete')">Delete</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="/">
            <input type="hidden" name="_token" id="_token" required>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">System Alert!</h4>
                </div>
                <div class="modal-body">
                    <p id="message"></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $('#dataTable').DataTable();

        function affiliateDelete(url) {
            $('#myModal form').attr('action', url);
            $('#_token').val($('meta[name="csrf-token"]').attr('content'));
            $('#message').html('Are you sure to delete this request?');
            $('#myModal').modal();
        }

        function affiliateReject(url) {
            $('#myModal form').attr('action', url);
            $('#_token').val($('meta[name="csrf-token"]').attr('content'));
            $('#message').html('Are you sure to reject this request?');
            $('#myModal').modal();
        }
    </script>
@endsection
