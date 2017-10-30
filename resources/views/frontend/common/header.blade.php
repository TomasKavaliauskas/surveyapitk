    <header>
		<div class="container">
			<div class="row">
				<nav class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
							<div class="navbar-brand">
								<a href="/"><h1>SurveyAPI.tk</h1></a>
							</div>
						</div>
						<div class="menu">
							<i class="fa fa-bars" id="hamburger"></i>
							<ul id="menu" class="nav nav-tabs" role="tablist">
								<li role="presentation" @if($current_page == '') class="active" @endif><a href="/">Pagrindinis</a></li>
								<li role="presentation" @if($current_page == 'api') class="active" @endif><a href="/api">API</a></li>		
								@if(!Auth::check())
									<li role="presentation" @if($current_page == 'register') class="active" @endif><a href="/login/google">Registracija / Prisijungimas</a></li>
								@else
									<li role="presentation" @if($current_page == 'surveys') class="active" @endif><a href="/surveys">Mano apklausos</a></li>
									<li role="presentation"><a href="/logout">Atsijungti</a></li>
								@endif								
							</ul>
						</div>
					</div>			
				</nav>
			</div>
		</div>
	</header>