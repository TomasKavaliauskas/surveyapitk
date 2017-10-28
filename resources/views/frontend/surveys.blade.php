@extends('frontend.layout.master')

@section('content')		
	<div class="content">
		<h2><span>Mano apklausos</span></h2>
		<p>Čia galite peržiūrėti savo apklausas bei kurti naujas.</p>
		<a href="/surveys/create" class="btn btn-primary">Kurti naują</a>
	</div>
	<div class="breadcrumb">
		<h4>Mano apklausos</h4>
	</div>
	
	
	<div class="container">
		<div class="row">
			<div class="boxs">	

				@if(session('error')) 
					<div class="alert alert-danger">
					  <strong>Klaida!</strong> {{ session('error')  }}
					</div>				
				@endif
				
				@if(session('success')) 
					<div class="alert alert-danger">
					  <strong>Sėkmė!</strong> {{ session('success')  }}
					</div>				
				@endif				
			
				@if($surveys)
					@foreach($surveys as $survey)
						<div class="col-md-4">
							<div class="wow bounceIn" data-wow-offset="0" data-wow-delay="0.8s">
								<div class="align-center">
									<h4>{{ $survey->title }}</h4>					
									<div class="icon">
										<i class="fa {{ $survey->icon }} fa-3x"></i>
									</div>
									<p>
									 {{ $survey->description }}
									</p>
									<div class="ficon">
										<a style="color: red;" style="cursor: pointer;" href="#" data-toggle="modal" data-target="#modal-{{$survey->id}}" alt="">Statistika</a>
										<a style="color: red;" href="/surveys/edit/{{ $survey->id }}" alt="">Redaguoti</a>
										<a style="color: red;" href="/surveys/delete/{{ $survey->id }}" alt="">Naikinti</a> 
									</div>
								</div>
							</div>
						</div>
						<div id="modal-{{$survey->id}}" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Statistika</h4>
							  </div>
							  <div class="modal-body">
				
								@foreach($survey->questions as $question)

											<div>
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
									
									
								@endforeach
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>

						  </div>
						</div>						
					@endforeach
				@else
					<p>Jūs neturite nė vienos apklausos.</p>
				@endif
				
			</div>
		</div>
	</div>

@endsection	