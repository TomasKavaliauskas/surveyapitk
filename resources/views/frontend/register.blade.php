@extends('frontend.layout.master')

@section('content')	

	<div class="content">
		<h2><span>Registracija</span></h2>
	</div>
	<div class="breadcrumb">
		<h4>Uzpildykite laukus</h4>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="boxs">		
				
					@if(session('error')) 
						<div class="alert alert-danger">
						  <strong>Klaida!</strong> {{ session('error')  }}
						</div>				
					@endif				
				
				<form method="post" action="register">
					<div class="form-group">
						<input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Vartotojo vardas">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" value="" placeholder="Slaptazodis">
					</div>
					<div class="form-group">
						<input type="password" name="password_match" class="form-control" value="" placeholder="Pakartokite slaptazodi">
					</div>	
					<div class="form-group">
						<input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="El pasto adresas">
					</div>			
					<button type="submit" class="btn btn-primary">Registruotis</button>
				</form>

			</div>
		</div>
	</div>

	
@endsection	