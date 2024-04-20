@extends('templates.admin')

@section('title')
	Company Profile - Visi & Misi
@endsection

@section('breadcrumb')
	<a href="{{ url('/admin/cp/') }}">&nbsp;Company Profile</a>&nbsp;/ Visi & Misi
@endsection

@section('content')

	@if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span class="fa fa-times"></span>
            </button>
        </div>
    @endif
	<div id="content">

		<div class="card">
			<div class="card-header">
				Visi & Misi
			</div>
			<div class="card-body">
				<form method="post">
					@method('PUT')
					@csrf
					<div class="form-group">
						<label for="f_vision">Visi</label>
						<textarea class="form-control" rows="3" name="vision" id="f_vision">{!! stripslashes($cp[0]->content) !!}</textarea>
					</div>
					<div class="form-group mt-3">
						<label for="f_mission">Misi</label>
						<textarea class="form-control" rows="3" name="mission" id="f_mission">{!! stripslashes($cp[1]->content) !!}</textarea>
					</div>
					<button type="submit" class="btn btn-success mt-2"><i class="fa fa-save mr-2"></i>Perbarui</button>
			    	<p class="float-right mt-2">Terakhir diperbarui oleh {{ $cp[0]->user->name }} pada {{ Sirius::toIdLongDateDay($cp[0]->updated_at) }}</p>
				</form>
			</div>
		</div>

	</div>

	<script type="text/javascript">
		CKEDITOR.replace('f_vision', {
		    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
		    filebrowserUploadMethod: 'form'
		});

		CKEDITOR.replace('f_mission', {
		    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
		    filebrowserUploadMethod: 'form'
		});
	</script>
@endsection

@section('addjs')
	<script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
@endsection
