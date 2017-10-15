@extends('frontend.layout.master')

@section('content')	

	<div class="content">
		<h2><span>Prisijungimas</span></h2>
	</div>

	
	<div class="container">
		<div class="row">
			<div class="boxs">	

				@if(session('error')) 
					<div class="alert alert-danger">
					  <strong>Klaida!</strong> {{ session('error')  }}
					</div>				
				@endif			
				
				<form method="post" action="login">
					<div class="form-group">
						<input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" value="" placeholder="Slaptazodis">
					</div>
					<button type="submit" class="btn btn-primary">Prisijungti</button>
				</form>

			</div>
		</div>
	</div>

	
@endsection	