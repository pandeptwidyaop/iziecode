@extends(load_view('layouts.app'))

@section('content')
@php
@$config = $template->config == null ? [] : $template->config;
@endphp
<!-- Content Wrapper. Contains page content -->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$template->title}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li><a href="{!! route(config('iziecode.dashboard-route')) !!}"><i class="fa fa-dashboard"></i> Home</a></li> / 
                    <li class="active">{{$template->title}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                {!! \Iziedev\Iziecode\App\Helpers\Alert::showBox()!!}
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title"><i class="{{$template->icon}}"></i> List {{$template->title}}</h3>
                        <a href="{{route("$template->route".'.create')}}"
                            class="btn btn-primary pull-right {{ \Iziedev\Iziecode\App\Helpers\AppHelper::config($config,'index.create.is_show') ?  \Iziedev\Iziecode\App\Helpers\AppHelper::config($config,'index.create.is_show') : 'hidden'}}">
                            <x-ez-icon  name="apps-outline"  /> Tambah {{$template->title}}
                            
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table" id="datatables">
                            <thead>
                                <tr>
                                    <td>No.</td>
                                    @foreach ($form as $item)
                                    @if (array_key_exists('view_index',$item) && $item['view_index'])
                                    @if(array_key_exists('format',$item) && $item['format'] == 'rupiah')
                                    <td>{{$item['label']}} (Rp)</td>
                                    @else
                                    <td>{{$item['label']}}</td>
                                    @endif
                                    @endif
                                    @endforeach
                                    <td>Opsi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $row)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    @foreach ($form as $item)
                                    @if (array_key_exists('view_index',$item) && $item['view_index'])
                                    <td @if(array_key_exists('format',$item) && $item['format']=='rupiah' )
                                        style="text-align:right" @endif>
                                        @if (array_key_exists('view_relation',$item))
                                        {{  \Iziedev\Iziecode\App\Helpers\AppHelper::viewRelation($row,$item['view_relation']) }}
                                        @else
                                        @if(array_key_exists('format',$item) && $item['format'] == 'rupiah')
                                        {{number_format($row->{$item['name']},2,',','.')}}
                                        @else
                                        {{ $row->{$item['name']} }}
                                        @endif
                                        @endif
                                    </td>
                                    @endif
                                    @endforeach
                                    <td>
                                        <a href="{{route("$template->route".'.edit',[$row->id])}}"
                                            class="btn btn-success btn-sm {{ \Iziedev\Iziecode\App\Helpers\AppHelper::config($config,'index.edit.is_show') ? '' : 'hidden'}}">Ubah</a>
                                        <a href="{{route("$template->route".'.show',[$row->id])}}"
                                            class="btn btn-info btn-sm {{ \Iziedev\Iziecode\App\Helpers\AppHelper::config($config,'index.show.is_show') ? '' : 'hidden'}}">Lihat</a>
                                        <a href="#"
                                            class="btn btn-danger btn-sm {{ \Iziedev\Iziecode\App\Helpers\AppHelper::config($config,'index.delete.is_show') ? '' : 'hidden'}}"
                                            onclick="confirm('Lanjutkan ?') ? $('#frmDelete{{$row->id}}').submit() : ''">Hapus</a>
                                        <form action="{{route("$template->route".'.destroy',[$row->id])}}" method="POST"
                                            id="frmDelete{{$row->id}}">
                                            {{ csrf_field() }}
                                            @method('DELETE')
                                        </form>
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
</div>
@endsection
@push('css')
<style>
    /* #datatables th,#datatables td, #datatables thead{
            border : 1px solid #b9b9b9;
            border-bottom: 1px solid #b9b9b9 !important;
        }
        #datatables th{
            text-align: center;
        } */

</style>
@endpush
@push('js')
<!-- page script -->
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script>
    
    $(function () {
        $('#datatables').DataTable()
        $('#full-datatables').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    })

</script>

@endpush
