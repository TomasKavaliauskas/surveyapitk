@extends('frontend.layout.master')

@section('content')		
<form method="post" action="/surveys/edit/{{ $survey->id }}">
	<div class="content">
		<h2><span>Apklausos redagavimas</span></h2>
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
				
					{{ csrf_field() }}
					<div class="form-group">
						<input type="text" name="title" class="form-control" value="{{ $survey->title }}" placeholder="Apklausos pavadinimas"/>
					</div>
					
					<div class="form-group">
						<textarea name="description" class="form-control" placeholder="Apklausos aprašymas">{{ $survey->description }}</textarea>
					</div>
					
					<div class="form-group">
						<select name="icon" class="form-control">
							<option <?php if($survey->icon == 'fa-laptop') { echo "selected"; } ?> value="fa-laptop">fa-laptop</option>
							<option <?php if($survey->icon == 'fa-heart-o') { echo "selected"; } ?> value="fa-heart-o">fa-heart-o</option>
						</select>
					</div>

				
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="boxs" id="questions">

				<div id="questions-block">
					
					@foreach($survey->questions as $question)
					
						<div id="question_{{ $question->id }}" style="margin-bottom: 50px">
							<div class="form-group">
								<input placeholder="Klausimas" type="text" class="form-control" readonly name="question_{{ $question->id }}_title" value="{{ $question->question }}"/>
							</div>
							<div class="form-group">
								<input placeholder="Pasirinkimas 1" class="form-control" readonly type="text" name="question_{{ $question->id }}_option_1" value="{{ $question->option1 }}"/>
							</div>
							<div class="form-group">
								<input placeholder="Pasirinkimas 2" class="form-control" readonly type="text" name="question_{{ $question->id }}_option_2" value="{{ $question->option2 }}"/>
							</div>
							<div class="form-group">
								<input placeholder="Pasirinkimas 3" class="form-control" readonly type="text" name="question_{{ $question->id }}_option_3" value="{{ $question->option3 }}"/>
							</div>
							<div class="form-group">
								<input placeholder="Pasirinkimas 4" class="form-control" readonly type="text" name="question_{{ $question->id }}_option_4" value="{{ $question->option4 }}"/>
							</div>
						</div>
					@endforeach
					
					<button class="btn btn-primary" id="create-button" type="submit">Redaguoti apklausą</button>
				</div>
				
			</div>
		</div>
	</div>	
					
</form>
@endsection	