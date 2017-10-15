@extends('frontend.layout.master')

@section('content')	

	<form method="post" action="/surveys/{{ $survey->id }}">
	
		<div class="content">
			<h2><span>{{ $survey->title }}</span></h2>
			<p><strong>{{ $survey->description }}</strong></p>
		</div>
		<div class="breadcrumb">
			<h4>Klausimai</h4>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="boxs">		
				
					@if(session('error')) 
						<div class="alert alert-danger">
						  <strong>Klaida!</strong> {{ session('error')  }}
						</div>				
					@endif
					
					@foreach($survey->questions as $question)
						
						<div class="col-md-12">
							<div class="wow bounceIn" data-wow-offset="0" data-wow-delay="0.8s">
								<div class="align-center">
									<h4>{{ $question->question }}</h4>	
									<p>
									 @if($question->option1 != null)
										<input type="radio" name="answer_{{ $question->id }}" value="1" class="form-control"/> {{ $question->option1 }}
									 @endif
									 @if($question->option2 != null)
										<input type="radio" name="answer_{{ $question->id }}" value="2" class="form-control"/> {{ $question->option2 }}
									 @endif
									 @if($question->option3 != null)
										<input type="radio" name="answer_{{ $question->id }}" value="3" class="form-control"/> {{ $question->option3 }}
									 @endif
									 @if($question->option4 != null)
										<input type="radio" name="answer_{{ $question->id }}" value="4" class="form-control"/> {{ $question->option4 }}
									 @endif
									</p>
								</div>
							</div>
						</div>
						
						
					@endforeach
					
					<button type="submit" class="btn btn-primary">Atsakyti</button>
				</div>
			</div>
		</div>

	</form>
	
@endsection	