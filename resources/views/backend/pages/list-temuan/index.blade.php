@extends('backend.layouts.master')

@section('title')
    <title>Daftar Temuan</title>
@endsection
@section('modal')
    <div class="modal fade" id="modalhapus" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Konfirmasi Hapus Detail Temuan</h4>
				</div>
				<div class="modal-body">
					<h5>Apakah anda yakin akan menghapus data ini?</h5>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
					<a class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('form-delete').submit();" style="cursor:pointer;">Ya, Saya Yakin</a>
                    <form id="form-delete" method="POST" style="display: none;" action="{{url('detail-temuan-delete')}}">
                        @csrf
                        <input type="hidden" name="id" id="iddetail">
					</form>
				</div>
			</div>
		</div>
	</div>
    <div class="modal fade" id="modalverifikasi" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Verifikasi Detail Temuan</h4>
				</div>
				<div class="modal-body">
					<h5>Apakah anda yakin akan me-verifikasi data ini?</h5>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
					<a class="btn btn-info" onclick="event.preventDefault(); document.getElementById('form-verifikasi').submit();" style="cursor:pointer;">Ya, Saya Yakin</a>
                    <form id="form-verifikasi" method="POST" style="display: none;" action="{{url('detail-temuan-verifikasi')}}">
                        @csrf
                        <input type="hidden" name="id" id="iddetailverif">
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('content')
@php
    $dinas_id=$tahun=$pengawasan_id='';
    if(Session::has('dinas_id'))
    {
        $dinas_id=Session::get('dinas_id');
    }                                    
    if(Session::has('tahun'))
    {
        $tahun=Session::get('tahun');
    }                                    
    if(Session::has('pengawasan_id'))
    {
        $pengawasan_id=Session::get('pengawasan_id');
    }                                    
@endphp
	<div class="col-md-12">
		<div class="widget">
			<header class="widget-header">
				<span class="widget-title">Daftar Temuan</span>
            </header>
            
			<hr class="widget-separator">
			<div class="widget-body">
                
				<div class="table-responsive">
                    
                    <div class="row" style="">
                        <div class="col-md-12">
                            
                            <div id="data">
                                <div class="text-center"><h4>Silahkan Pilih Data OPD, Tahun Pemeriksaan dan Bidang Pengawasan Terlebih Dahulu</h4></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footscript')
    <link rel="stylesheet" href="{{asset('theme/backend/libs/misc/datatables/datatables.min.css')}}"/>
    <script src="{{asset('theme/backend/libs/misc/datatables/datatables.min.js')}}"></script>
	<script>
        // loaddata(-1,-1);
        var dinas_id='{{$dinas_id}}';
        var tahun='{{$tahun}}';
        var pengawasan_id='{{$pengawasan_id}}';
        
        if(dinas_id!='' && tahun!='' && pengawasan_id!='')
        {
            loaddata(dinas_id,tahun,pengawasan_id);
        }
        else
        {
            if(dinas_id!='')
                loaddata(dinas_id,-1,-1);
            else
                loaddata(-1,-1,-1);
        }

        function getdata()
        {
            var dinas_id=$('#dinas_id').val();
            var tahun=$('#tahun').val();
            var bidang=$('#bidang').val();
            loaddata(dinas_id,tahun,bidang);
        }
        
        function loaddata(dinas_id,tahun,bidang)
        {
            if(bidang!='')
            {
                $('#data').load('{{url("list-temuan-data")}}/'+dinas_id+'/'+tahun+'/'+bidang,function(){
                    $('#table').DataTable();
                });
            }
            else
            {
                $('#data').load('{{url("list-temuan-data")}}/'+dinas_id+'/'+tahun,function(){
                    $('#table').DataTable();
                });
            }
            
        }
        function hapusdetail(id)
        {
            $('#iddetail').val(id);
            $('#modalhapus').modal('show');
        }
        function verifikasi(id)
        {
            $('#iddetailverif').val(id);
            $('#modalverifikasi').modal('show');
        }
    </script>
    <style>
    .form-inline .btn
    {
        height:24px !important;
    }
    </style>
@endsection
