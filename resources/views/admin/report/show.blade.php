@extends('templates.admin')

@section('title')
	Lihat Laporan Audit
@endsection

@section('breadcrumb')
	<a href="{{ url('admin/report') }}">&nbsp;Laporan Audit</a>&nbsp;/&nbsp;Lihat Laporan Audit&nbsp;/&nbsp;{{ $report->subject }}
@endsection

@section('content')

	<div id="show">

		<div id="content">
			<a href="{{ url('admin/report') }}"><button class="btn btn-danger mb-4 mr-3"><i class="fa fa-arrow-circle-left mr-2"></i>Kembali</button></a>
			<button id="b_edit" class="btn btn-info mb-4"><i class="fa fa-file-signature mr-2"></i>Sunting Laporan</button>
			@if (session('message'))
	            <div class="alert alert-success alert-dismissible fade show" role="alert">
	                {{ session('message') }}
	                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                    <span class="fa fa-times"></span>
	                </button>
	            </div>
	        @endif
			<div class="card mb-3">
			    <div class="card-header">
			        {{ $report->subject }}
			    </div>
				<div class="card-body">
					{!! $report->content !!}
				</div>
			</div>

			<div id="report_attachments" class="card">
			    <div class="card-header">
			        <i class="fas fa-paperclip mr-2"></i>Lampiran <a href="#" id="b_adder"><span class="badge badge-success ml-2">TAMBAH LAMPIRAN</span></a>
			    </div>
			    </di>
			    <div class="card-body">
					@if (session('messageAttachment'))
			            <div class="alert alert-success alert-dismissible fade show" role="alert">
			                {{ session('messageAttachment') }}
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span class="fa fa-times"></span>
			                </button>
			            </div>
			        @endif
					@if (count($report->reportAttachments) > 0)
					    @foreach ($report->reportAttachments as $attachment)
						    <span>
						    	<input type="hidden" name="id" class="fr_id" value="{{ $attachment->id }}">
							    <a href="{{ asset('/attachments/'.$attachment->id.'｜'.$attachment->name.$attachment->ext) }}" class="p-2 border align-middle" style="font-weight: bolder;">
							    	@if ($attachment->ext == ".doc" || $attachment->ext == ".docx")
							    		<i class="fa fa-file-word mr-1"></i>
							    	@else
								    	@if ($attachment->ext == ".ppt" || $attachment->ext == ".pptx")
								    		<i class="fa fa-file-powerpoint mr-1"></i>
							    		@else
								    		@if ($attachment->ext == ".xls" || $attachment->ext == ".xlsx")
									    		<i class="fa fa-file-excel mr-1"></i>
									    	@else
									    		@if ($attachment->ext == ".zip" || $attachment->ext == ".rar")
										    		<i class="fa fa-file-archive mr-1"></i>
										    	@else
											    	@if ($attachment->ext == ".pdf")
											    		<i class="fa fa-file-pdf mr-1"></i>
											    	@else
											    		<i class="fa fa-file-alt mr-1"></i>
											    	@endif
										    	@endif
									    	@endif
								    	@endif
							    	@endif
							    	{{ $attachment->name.$attachment->ext }}
							    </a><a href="#" class="b_remove"><span class="badge badge-danger mr-3 p-3 align-middle"><i class="fa fa-trash"></i></span></a>
						    </span>
					    @endforeach
					@else
						Tidak ada lampiran.
					@endif
				</div>
			</div>
		</div>
	</div>

	<div id="editor" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-file-signature mr-2"></i>Sunting Laporan
	    </div>
	    <div class="card-body">
			<form method="post">
				@method('PUT')
				@csrf

				<div class="form-group">
					<label for="fe_subject">Judul Laporan</label>
					<input type="text" class="form-control" id="fe_subject" name="subject" value="{{ $report->subject }}">
				</div>
				<div class="form-group">
					<label for="fe_content">Isi Laporan</label>
					<textarea class="form-control" id="fe_content" name="content">{!! $report->content !!}</textarea>
				</div>


				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<div id="adder" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-paperclip mr-2"></i>Tambah Lampiran Laporan Ini
	    </div>
	    <div class="card-body">
			<form method="post" action="{{ url('admin/report/'.$report->id.'/attachment_add') }}" enctype="multipart/form-data">
				@method('PUT')
				@csrf

				<input type="file" id="fa_attachments" name="attachments[]" class="attachments" style="display: none;" multiple>
				<label for="fa_attachments">Lampiran</label>
				<div class="input-group">
					<input type="text" class="form-control mb-3" disabled placeholder="Unggah Lampiran ..." id="attachments">
					<div class="input-group-append">
						<button type="button" class="browse btn btn-primary mb-3">Cari ...</button>
					</div>
				</div>


				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<div id="remover" style="display: none;">
		<form method="post" action="" id="f_remover">
			@method('DELETE')
			@csrf
		</form>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on("click", ".browse", function() {
				var file = $("#fa_attachments");
				file.trigger("click");
			});
			$('input[type="file"]').change(function(e) {
				let filenames = e.target.files[0].name;
				if (e.target.files.length > 1) {
					for (var i = 1; i < e.target.files.length; i++) {
						filenames += ", " + e.target.files[i].name;
					}
				}
				$("#attachments").val(filenames);
			});
		});

		CKEDITOR.replace('fe_content', {
		    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
		    filebrowserUploadMethod: 'form'
		});

		$("#b_edit").click(function(){
			$("#content").slideUp();
			$("#editor").slideDown();
		});

		$("#b_adder").click(function(){
			$("#content").slideUp();
			$("#adder").slideDown();
		});
		$(".b_cancel").click(function(){
			$("#content").slideDown();
			$(this).parent().parent().parent().slideUp();
		});

		$(".b_save").click(function(){
			let dis = $(this);
			setTimeout(function(){
				dis.prop('disabled', true);
			},50);
			dis.html('<i class="spinner-border spinner-border-sm mr-2"></i>Menyimpan ...');
			dis.parent().children(".b_cancel").prop("disabled", true);
		});
		$(".b_remove").click(function(){
			let id = $(this).parent().find(".fr_id").val();
			let remove = confirm('Yakin ingin membuang lampiran ini dari laporan?')
			if (remove == true) {
				$("#f_remover").attr('action', '{{ url("/admin/reports/attachment_delete") }}/' + id);
				$("#f_remover").submit();
			}
		});
	</script>
@endsection

@section('addjs')
	<script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
@endsection
