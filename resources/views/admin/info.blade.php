@extends('templates.admin')

@section('title')
	Informasi Situs
@endsection

@section('breadcrumb')
	Informasi Situs
@endsection

@section('content')
	<div id="content">
		@if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span class="fa fa-times"></span>
                </button>
            </div>
        @endif
		<form method="post">
			@csrf
			<div class="card mb-4">
			    <div class="card-header">
			        <i class="fas fa-phone mr-2"></i>Informasi Kontak Perusahaan
			    </div>
		    	<div class="card-body">
					<div class="form-group">
						<label for="address">Alamat Perusahaan</label>
						<input type="text" required class="form-control" id="address" aria-describedby="addressHelp" name="infos[address]" value="{{ $infos['address']??"" }}">
						<small id="addressHelp" class="form-text text-muted">address</small>
					</div>
					<div class="form-group">
						<label for="phone">Nomor Telepon Perusahaan</label>
						<input type="text" required class="form-control" id="phone" aria-describedby="phoneHelp" name="infos[phone]" value="{{ $infos['phone']??"" }}">
						<small id="phoneHelp" class="form-text text-muted">phone</small>
					</div>
					<div class="form-group">
						<label for="website">Alamat Situs Perusahaan</label>
						<input type="url" required class="form-control" id="website" aria-describedby="websiteHelp" name="infos[website]" value="{{ $infos['website']??"" }}">
						<small id="websiteHelp" class="form-text text-muted">website</small>
					</div>
		    	</div>
			</div>
			<div class="card mb-4">
			    <div class="card-header">
			        <i class="fas fa-envelope mr-2"></i>Email
			    </div>
		    	<div class="card-body">
					<div class="form-group">
						<label for="admin_mail">Email Admin</label>
						<input type="email" required class="form-control" id="admin_mail" aria-describedby="admin_mailHelp" name="infos[admin_mail]" value="{{ $infos['admin_mail']??"" }}">
						<small id="admin_mailHelp" class="form-text text-muted">admin_mail</small>
					</div>
					<div class="form-group">
						<label for="no_reply_mail">Email yang Tidak Boleh Dibalas</label>
						<input type="email" required class="form-control" id="no_reply_mail" aria-describedby="no_reply_mailHelp" name="infos[no_reply_mail]" value="{{ $infos['no_reply_mail']??"" }}">
						<small id="no_reply_mailHelp" class="form-text text-muted">no_reply_mail</small>
					</div>
					<div class="form-group">
						<label for="booked_appointment_mail">Email Penerima Jadwal Audit</label>
						<input type="email" required class="form-control" id="booked_appointment_mail" aria-describedby="booked_appointment_mailHelp" name="infos[booked_appointment_mail]" value="{{ $infos['booked_appointment_mail']??"" }}">
						<small id="booked_appointment_mailHelp" class="form-text text-muted">booked_appointment_mail</small>
					</div>
					<div class="form-group">
						<label for="customer_service_mail">Email Customer Service</label>
						<input type="email" required class="form-control" id="customer_service_mail" aria-describedby="customer_service_mailHelp" name="infos[customer_service_mail]" value="{{ $infos['customer_service_mail']??"" }}">
						<small id="customer_service_mailHelp" class="form-text text-muted">customer_service_mail</small>
					</div>
		    	</div>
			</div>
			<div class="card mb-4">
			    <div class="card-header">
			        <i class="fas fa-user-circle mr-2"></i>Link Media Sosial
			    </div>
		    	<div class="card-body">
					<div class="form-group">
						<label for="facebook">Facebook</label>
						<input type="url" class="form-control" id="facebook" aria-describedby="facebookHelp" name="infos[facebook]" value="{{ $infos['facebook']??"" }}">
						<small id="facebookHelp" class="form-text text-muted">facebook</small>
					</div>
					<div class="form-group">
						<label for="twitter">Twitter</label>
						<input type="url" class="form-control" id="twitter" aria-describedby="twitterHelp" name="infos[twitter]" value="{{ $infos['twitter']??"" }}">
						<small id="twitterHelp" class="form-text text-muted">twitter</small>
					</div>
					<div class="form-group">
						<label for="instagram">Instagram</label>
						<input type="url" class="form-control" id="instagram" aria-describedby="instagramHelp" name="infos[instagram]" value="{{ $infos['instagram']??"" }}">
						<small id="instagramHelp" class="form-text text-muted">instagram</small>
					</div>
		    	</div>
			</div>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</form>
	</div>
@endsection
