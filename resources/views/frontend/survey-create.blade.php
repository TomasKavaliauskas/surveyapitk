@extends('frontend.layout.master')

@section('content')		
<form method="post" action="/surveys/create">
	<div class="content">
		<h2><span>Nauja apklausa</span></h2>
	</div>
	<div class="breadcrumb">
		<h4>Užpildykite formą</h4>
	</div>
	
	
	<div class="container">
		<div class="row">
			<div class="boxs">		
					
					@if(session('error')) 
						<div class="alert alert-danger">
						  <strong>Klaida!</strong> {{ session('error')  }}
						</div>				
					@endif
				
					<div class="form-group">
						<input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Apklausos pavadinimas"/>
					</div>
					
					<div class="form-group">
						<textarea name="description" class="form-control" placeholder="Apklausos aprašymas">{{ old('description') }}</textarea>
					</div>
					
					<div class="form-group">
						<select name="icon" class="form-control">
							<option value="fa-laptop">fa-laptop</option>
							<option value="fa-heart-o">fa-heart-o</option>
						</select>
					</div>

				
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="boxs" id="questions">

				<div id="questions-block">
				
				</div>
				
				<div id="buttons">
					<button id="add-question" class="btn btn-primary">Pridėti klausimą</button>
				</div>
				
			</div>
		</div>
	</div>	
					
</form>
@endsection	