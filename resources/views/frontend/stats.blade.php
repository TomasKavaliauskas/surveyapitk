@extends('frontend.layout.master')

@section('content')	

	<div class="content">
		<h2><span>{{ $survey->title }}</span></h2>
		<p><strong>{{ $survey->description }}</strong></p>
	</div>
	<div class="breadcrumb">
		<h4>Klausimu statistika</h4>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="boxs">		
				
				@foreach($survey->questions as $question)
					
					<div class="col-md-12">
						<div class="wow bounceIn" data-wow-offset="0" data-wow-delay="0.8s">
							<div class="align-center">
								<h4>{{ $question->question }}</h4>	
								<p>
								 @if($question->option1 != null)
									{{ $question->option1 }} : {{ $question->option1_votes }}  balsai</br>
								 @endif
								 @if($question->option2 != null)
									{{ $question->option2 }} : {{ $question->option2_votes }} balsai</br>
								 @endif
								 @if($question->option3 != null)
									{{ $question->option3 }} : {{ $question->option3_votes }} balsai</br>
								 @endif
								 @if($question->option4 != null)
									{{ $question->option4 }} : {{ $question->option4_votes }} balsai
								 @endif
								</p>
							</div>
						</div>
					</div>
					
					
				@endforeach

			</div>
		</div>
	</div>

	
@endsection	