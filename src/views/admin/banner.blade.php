@extends('admin.master')

@section('title')
    Admin | Banner
@endsection

@section('breadcrumbs')
    <li>Banner</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-lg-12 mt-5">
                <div class="box">
                    <form action="{!! url('admin/affiliate-banner/store') !!}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{!! data('id', $data) !!}">
                        <div class="box-body">
                        <h4 class="header-title">Banner Add and update</h4>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Heading</label>
                                    <input class="form-control" type="text" name="banner_heading" value="{!! data('banner_heading', $data) !!}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Image</label>
                                    <div class="custom-file preview-container">
                                        <input id="image" onchange="imagePreview(this,'#image-preview')" type="file" name="banner_image" class="custom-file-input form-control" accept="image/*">
                                        <img id="image-preview" class="image-preview" src="{!! url('images/affiliateBanners/'.data('banner_image', $data))!!}" />
                                        <div class="invalid-feedback">
                                            {!! implode('<br/>',$errors->get('banner_image')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="form-control" name="status">
                                        @php ($status = data('status', $data))
                                        <option value="Active" {{ ($status=='Active')?'selected':'' }}>Active</option>
                                        <option value="Inactive" {{ ($status=='Inactive')?'selected':'' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                            <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group  {!! $errors->has('banner_message')?'has-error':'' !!}">
                                    <label class="col-form-label">Message</label>
                                    <textarea id="ckeditor" class="form-control" name="banner_message">{!! data('banner_message', $data) !!}</textarea>
                                    <div class="invalid-feedback">
                                        {!! implode('<br />',$errors->get('banner_message')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button  type="submit" class="btn btn-rounded btn-primary mb-3">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- data table start -->
    <div class="col-lg-12 mt-5">
        <div class="box">
            <div class="box-body">
                <h4 class="header-title">Banner list</h4>
                <div class="data-tables">
                    <table id="dataTable" class="table table-hover w-100">
                        <thead class="bg-light text-capitalize">
                        <tr>
                            <th>Heading</th>
                            <th>Message</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $val)
                        <tr>
                            <td>{!! $val->banner_heading !!}</td>
                            <td>{!! $val->banner_message !!}</td>
                            <td><img src="{!! asset('images/affiliateBanners/'. $val->banner_image) !!}" width="40"></td>
                            <td>{!! $val->status !!}</td>
                            <td class="text-right">
                                <a href="{!! url('admin/affiliate-banner', $val->id) !!}/edit">Edit</a> |
                                <a href="{!! url('admin/affiliate-banner', $val->id) !!}/delete">Delete</a>
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@endsection
@section('scripts')
    <script>
        $('#dataTable').DataTable();

        $(document).ready(function(){
            var config = {};
            CKEDITOR.replace( 'ckeditor', config );
        });
    </script>
@endsection
