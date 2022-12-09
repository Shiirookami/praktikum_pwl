@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="container-fluid">
    <div class="card card-default">
        <div class="card-header">{{ __(pengelolan Buku)}}</div>
        <div class="card-body">
            <button
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#tambahBukuModal">
                <i class="fa fa-plus"></i>Tambah Data</button>
            <table id="table-data" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>no</th>
                        <th>judul</th>
                        <th>penulis</th>
                        <th>tahun</th>
                        <th>penerbit</th>
                        <th>cover</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1 @endphp @foreach ($books as $book)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$book->judul}}</td>
                        <td>{{$book->penulis}}</td>
                        <td>{{$book->tahun}}</td>
                        <td>{{$book->penerbit}}</td>
                    </tr>
                    <tr>

                        <td>

                            @if($book->cover !==null)
                            <img src="{{asset('storage/cover_buku/'.$book->cover)}}" width="100px">

                            @else [gambar tidak tersedia] @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-succes" data-toggle="modal"data-target="#editBukuModal" data-id="{{$book->id}}">>Edit</button>
                                <button type="button" class="btn btn-danger" onclick="deleteConfirmation('{{$book->id}}'),('{{$book->judul}}')" >Hapus</button>
                            </div>
                        </td>

                    </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('admin.book.submit')}}" enctype="multipart/form-data" >
            @csrf
          <div class="form-group">
            <label for="judul" class="col-form-label">Judul</label>
            <input type="text" class="form-control" id="judul"name="judul" required>
          </div>
          <div class="form-group">
            <label for="penulis" class="col-form-label">penulis</label>
            <input type="text" class="form-control" id="penulis"name="penulis" required>
          </div>
          <div class="form-group">
            <label for="tahun" class="col-form-label">tahun</label>
            <input type="text" class="form-control" id="tahun"name="tahun" required>
          </div>
          <div class="form-group">
            <label for="penerbit" class="col-form-label">penerbit</label>
            <input type="text" class="form-control" id="penerbit"name="penerbit" required>
          </div>
          <div class="form-group">
            <label for="cover" class="col-form-label">cover</label>
            <input type="file" class="form-control" id="cover"name="cover" required>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- edit --}}

<div class="modal fade" id="editBukuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{route('admin.book.update')}}" enctype="multipart/form-data" >
              @csrf
              @method('PATCH')
            <div class="form-group">
              <label for="edit-judul" class="col-form-label">edit-Judul</label>
              <input type="text" class="form-control" id="edit-judul"name="edit-judul" required>
            </div>
            <div class="form-group">
              <label for="edit-penulis" class="col-form-label">edit-penulis</label>
              <input type="text" class="form-control" id="edit-penulis"name="edit-penulis" required>
            </div>
            <div class="form-group">
              <label for="edit-tahun" class="col-form-label">edit-tahun</label>
              <input type="text" class="form-control" id="edit-tahun"name="edit-tahun" required>
            </div>
            <div class="form-group">
              <label for="edit-penerbit" class="col-form-label">edit-penerbit</label>
              <input type="text" class="form-control" id="edit-penerbit"name="edit-penerbit" required>
            </div>
            <div class="form-group">
              <label for="edit-cover" class="col-form-label">edit-cover</label>
              <input type="file" class="form-control" id="edit-cover"name="edit-cover" required>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id" id="edit-id">
            <input type="hidden" name="old_cover" id="edit-old-cover">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-succes">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <img src="" alt="">

@stop
@section('js')
<script>
    $(function () {
        $(document).on('click','#btn-edit-buku', function () {
            let id = $(this).data('id');

            $('image-area').empty();
            $.ajax({
                type="get",
                url: "{{url('/admin/ajaxadmin/dataBuku')}}/"+id,
                dataType: 'json',
                succes: function (res) {
                    $('#edit-judul').val(res.judul);
                    $('#edit-penerbit').val(res.penerbit);
                    $('#edit-penulis').val(res.penulis);
                    $('#edit-tahun').val(res.tahun);
                    $('#edit-id').val(res.id);
                    $('#edit-old-cover').val(res.cover);

                    if (res.cover !==null) {
                        $('#image-area').append(
                            "  <img src='"+baseurl+"/storage/cover_buku/"+res.cover+"' width='200px'>"
                        );
                }else{
                    $('#iamge-area').append('[gambar tidak tersedia]');
                    }
                },
            });
        });
    });

    function deleteConfirmation(npm,judul) {
        swal.fire({
            title: "Hapus?",
            type: 'warning',
            text: "Apakah anda akan mengahpus ini yakin"+ judul +"?!",

            showCancelButton: 10,
            confirmButtonText:"Ya, Lakukakan!",
            cancelButtonText: "tidak, Batalkan",
            reverseButtons: !0
        }).then(function(e) {
            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "books/delete/"+npm,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'json',
                    succes: function(results){
                        if (results.succes === true) {
                            swal.fire("Done!", results.message, "succes");
                            setTimeout(function () {
                                location.reload();
                            },1000);
                        } else {
                            swal.fire("error!",results.message, "error");
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        },function(dismiss){
                return false;
    })
}
</script>
@endsection


