@extends('admin.general.parent')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Show Data Article</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/article">Article</a></li>
                        <li class="breadcrumb-item active">Show Data</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Article Records</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Category Name</th>
                                        <th>Content</th>
                                        <th>Writter</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $item)

                                    <tr>
                                        <th>{{$loop->iteration }}</th>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->category_name}}</td>
                                        <td>{{substr($item->content, 0, 20)}}...</td>
                                        <td>{{$item->admin_name}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td style="white-space: nowrap;">
                                            <a href="/admin/article/{{$item->id_article}}/edit" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                            <div style="cursor: pointer" onclick="delet({{$item->id_article}})" class="btn btn-danger"><i class="fa fa-trash"></i></div>
                                            <a href="/admin/article/{{$item->id_article}}/pdf" style="cursor: pointer" target="_blank"  class="btn btn-light"><i class="fa fa-file-pdf-o"></i></div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Category Name</th>
                                        <th>Content</th>
                                        <th>Writter</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alert ! </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to delete this article ? </p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="/admin/article/delete">
                    @csrf
                    <input type="hidden" id="id_article" name="id" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function delet(key, evt) {
    $('#deletemodal').modal('show');
    $('#id_article').val(key);
    evt.preventDefault();
  };
</script>
@endsection