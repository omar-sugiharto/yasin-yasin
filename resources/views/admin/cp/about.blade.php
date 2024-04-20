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
	<div id="content">

		<div class="card">
			<div class="card-header">
				{{ $cp->title }}
			</div>
			<div class="card-body">
				<form method="post">
					@method('PUT')
					@csrf
					<textarea class="form-control" rows="3" name="content" id="ta_content">{{ stripslashes($cp->content) }}</textarea>
					<button type="submit" class="btn btn-success mt-3"><i class="fa fa-save mr-2"></i>Perbarui</button>
			    	<p class="float-right mt-3">Terakhir diperbarui oleh {{ $cp->user->name }} pada {{ Sirius::toIdLongDateDay($cp->updated_at) }}</p>
				</form>
			</div>
		</div>

	</div>
@endsection
