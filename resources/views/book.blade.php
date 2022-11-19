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
  <table id="table-data" class="table table-bordered" >
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
        @php $no=1 @endphp
        @foreach ($books as $book)
          <tr>
            <td>{{$no++}}</td>
            <td>{{$book->judul}}</td>
            <td>{{$book->penulis}}</td>
            <td>{{$book->tahun}}</td>
            <td>{{$book->penerbit}}</td>
          </tr>
          @if($book->cover !==null)
          <img src="{{asset('storage/cover_buku/'.$book->cover)}}"width="100px" >
          
            
        @endforeach
    </tbody>

  </table>
</div>
        </div>
    </div>
@stop
