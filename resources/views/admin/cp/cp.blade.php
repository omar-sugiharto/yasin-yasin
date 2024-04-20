@extends('templates.admin')

@section('title')
	Company Profile - {{ $cp->title }}
@endsection

@section('breadcrumb')
	<a href="{{ url('/admin/cp/') }}">&nbsp;Company Profile</a>&nbsp;/ {{ $cp->title }}
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

	@if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span class="fa fa-times"></span>
            </button>
        </div>
    @endif
	<div id="content">

		<div class="card">
			<div class="card-header">
				{{ $cp->title }}
			</div>
			<div class="card-body">
				<form method="post">
					@method('PUT')
					@csrf
                    <div class="mb-3">
                        <label for="f_title">Judul:</label>
                        <input type="text" class="form-control" name="title" id="f_title" value="{{ $cp->title ?? old('title') }}">
                    </div>
                    <label for="f_content">Konten:</label>
                    <textarea class="form-control" rows="3" name="content" id="f_content">{{ stripslashes($cp->content) ?? stripslashes(old('content')) }}</textarea>
                    <button type="submit" class="btn btn-success mt-3"><i class="fa fa-save mr-2"></i>Perbarui</button>
                    <p class="float-right mt-3">Terakhir diperbarui oleh {{ $cp->user->name }} pada {{ Sirius::toIdLongDateDay($cp->updated_at) }}</p>
				</form>
			</div>
		</div>

	</div>

	<script type="text/javascript">
		CKEDITOR.replace('f_content', {
		    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
		    filebrowserUploadMethod: 'form'
		});
	</script>
@endsection

@section('addjs')
	<script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
@endsection
