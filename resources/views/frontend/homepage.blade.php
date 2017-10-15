@extends('frontend.layout.master')

@section('content')		

	<div class="content">
		<h2><span>Apklausų kūrimo ir naudojimo platforma</span></h2>
		<p>Lengvai kurkite apklausas, į kurias galės atsakinėti kiti svetainės lankytojai. Sekite jų atsakymus. Savo kurtas apklausas, bei jų rezultatus pasiekite kur norite, naudodamiesi API paslauga.</p>
	</div>
	<div class="breadcrumb">
		<h4>Naujausios apklausos</h4>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="boxs">				

				@if($surveys)
					@foreach($surveys as $survey)
						<div class="col-md-4">
							<div class="wow bounceIn" data-wow-offset="0" data-wow-delay="0.8s">
								<div class="align-center">
									<h4>{{ $survey->title }}</h4>	
									<h5>Autorius: {{ $survey->user->name }}</h5>
									<div class="icon">
										<i class="fa {{ $survey->icon }} fa-3x"></i>
									</div>
									<p>
									 {{ $survey->description }}
									</p>
									<div class="ficon">
										@if(Auth::check())
											@if($survey->has_answered) 
												Jus jau atsakinejote i sia apklausa
											@else
												<a href="/surveys/{{ $survey->id }}" alt="">Apklausos nuoroda</a> 
											@endif
										@else
											Turite prisijungti, noredami atsakyti i apklausas
										@endif
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