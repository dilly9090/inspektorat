@extends('backend.layouts.master')

@section('modal')
	<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Tambah Data OPD</h4>
				</div>
				<div class="modal-body">
					<form action="{{ route('data-opd.store') }}" method="POST">
						@csrf
						<div class="form-group">
							<input name="nama_dinas" type="text" class="form-control" placeholder="Nama OPD">
						</div>
						<div class="form-group">
							<input name="singkatan" type="text" class="form-control" placeholder="Singkatan">
                        </div>
                        <div class="form-group">
							<select name="flag" class="form-control">
								<option value="">-- Pilih --</option>
								<option value="1">Aktif</option>
								<option value="0">Tidak Aktif</option>
							</select>
						</div>
						<div class="form-group">
							<textarea name="alamat" class="form-control" placeholder="ALamat"></textarea>
						</div>
						
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
					<input type="submit" class="btn btn-success" value="Simpan">
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalubah" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ubah Data OPD</h4>
				</div>
				<div class="modal-body">
					<form id="form-update" method="POST">
						@csrf
						@method('PUT')

						<div class="form-group">
							<input id="nama_dinas" name="nama_dinas" type="text" class="form-control" placeholder="Nama OPD">
						</div>
						<div class="form-group">
							<input id="singkatan" name="singkatan" type="text" class="form-control" placeholder="Singkatan">
                        </div>
                        <div class="form-group">
							<select name="flag" class="form-control" id="flag">
								<option value="">-- Pilih --</option>
								<option value="1">Aktif</option>
								<option value="0">Tidak Aktif</option>
							</select>
						</div>
						<textarea name="alamat" id="alamat" class="form-control" placeholder="ALamat"></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
					<input type="submit" class="btn btn-success" value="Simpan Perubahan">
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalhapus" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Konfirmasi Hapus Data OPD</h4>
				</div>
				<div class="modal-body">
					<h5>Apakah anda yakin akan menghapus data ini?</h5>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
					<a class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('form-delete').submit();" style="cursor:pointer;">Ya, Saya Yakin</a>
					<form id="form-delete" method="POST" style="display: none;">
						@csrf
						@method('DELETE')
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('content')
	<div class="col-md-12">
		<div class="widget">
			<header class="widget-header">
				<span class="widget-title">Data OPD</span>
				<a href="" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modaltambah">+ Tambah Data</a>
			</header><!-- .widget-header -->
			<hr class="widget-separator">
			<div class="widget-body">
				<div class="table-responsive">
					<table id="table" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="width:15px;">#</th>
								<th>Nama OPD</th>
								<th>Singkatan</th>
								<th>Alamat</th>
								<th>Flag</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($opds as $key => $opd)
								<tr>
									<td>{{ $key = $key + 1 }}</td>
									<td>{{ $opd->nama_dinas }}</td>
									<td>{{ $opd->singkatan }}</td>
									<td>{{ $opd->alamat }}</td>
									<td>
                                        @if ($opd->flag==1)
                                            <span class="label label-primary">Aktif</span>
                                        @else
                                            <span class="label label-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
									<td>
										<a class="btn btn-xs btn-warning btn-edit" data-toggle="modal" data-target="#modalubah" data-value="{{ $opd->id }}" style="height:24px !important;">
											<i class="fa fa-edit"></i>
										</a>
										<a href="#" class="btn btn-xs btn-danger btn-delete" data-toggle="modal" data-target="#modalhapus" data-value="{{ $opd->id }}" style="height:24px !important;">
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div><!-- .widget-body -->
		</div><!-- .widget -->
	</div>
@endsection

@section('footscript')
	<script>
		// binding data to modal edit
        $('#table').on('click', '.btn-edit', function(){
            var id = $(this).data('value')
			// alert(id);
            $.ajax({
                url: "{{ url('data-opd') }}/"+id+"/edit",
                success: function(res) {
					$('#form-update').attr('action', "{{ url('data-opd') }}/"+id)

					$('#nama_dinas').val(res.nama_dinas)
					$('#singkatan').val(res.singkatan)
					$('#alamat').val(res.alamat)
					$('#flag').val(res.flag)
                }
            })
        })

		// delete action
        $('#table').on('click', '.btn-delete', function(){
            var id = $(this).data('value')
			$('#form-delete').attr('action', "{{ url('data-opd') }}/"+id)			
        })
	</script>
@endsection