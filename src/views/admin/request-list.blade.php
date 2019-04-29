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
        <ul class="nav nav-tabs">
                <li class="nav-item  {!!_active(['pending'],3)!!}"><a class="nav-link" href="{{url('admin/affiliate-request/pending')}}">Pending</a></li>
                <li class="nav-item {!!_active(['approved'],3)!!}"><a class="nav-link" href="{{url('admin/affiliate-request/approved')}}">Approved</a></li>
                <li class="nav-item {!!_active(['rejected'],3)!!}"><a class="nav-link" href="{{url('admin/affiliate-request/rejected')}}">Rejected</a></li>
                <li class="nav-item  {!!_active(['all'],3)!!}"><a class="nav-link" href="{{url('admin/affiliate-request/all')}}">All</a></li>
        </ul>
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
                                @if($val->status=='Pending')
                                <a href="#" onclick="affiliateApprove('{{ url('admin/affiliate-request', $val->id) }}/approved')">Approve</a> |
                                <a href="#" onclick="affiliateReject('{{ url('admin/affiliate-request', $val->id) }}/rejected')">Reject</a>

                                @elseif($val->status=='Approved')
                                <a href="#" onclick="affiliateReject('{{ url('admin/affiliate-request', $val->id) }}/rejected')">Reject</a> |
                                <a href="#" onclick="affiliateDelete('{{ url('admin/affiliate-request', $val->id) }}/delete')">Delete</a>

                                @elseif($val->status=='Rejected')
                                <a href="#" onclick="affiliateApprove('{{ url('admin/affiliate-request', $val->id) }}/approved')">Approve</a> |
                                <a href="#" onclick="affiliateDelete('{{ url('admin/affiliate-request', $val->id) }}/delete')">Delete</a>
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
<div id="appModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="/" class="form-horizontal">
            <input type="hidden" name="_token" id="_token2" required>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Approval Form</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="col-sm-10 col-sm-offset-2">Affiliate code will be auto generate.</p>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Commission:</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="number" step="1" min="1" value="5" class="form-control" name="commission" required>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Using Limit:</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="number" step="1" min="1" value="300" class="form-control" name="use_limit" required>
                                        <span class="input-group-addon"><i class="fa fa-refresh"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">Approve</button>
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

        function affiliateApprove(url) {
            $('#appModal form').attr('action', url);
            $('#_token2').val($('meta[name="csrf-token"]').attr('content'));
            $('#appModal').modal();
        }
    </script>
@endsection
