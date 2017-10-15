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
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="/">Pagrindinis</a></li>
								<li role="presentation"><a href="/api">API</a></li>		
								@if(!Auth::check())
									<li role="presentation"><a href="/register">Registracija</a></li>
									<li role="presentation"><a href="/login">Prisijungimas</a></li>
								@else
									<li role="presentation"><a href="/surveys">Mano apklausos</a></li>
									<li role="presentation"><a href="/logout">Atsijungti</a></li>
								@endif								
							</ul>
						</div>
					</div>			
				</nav>
			</div>
		</div>
	</header>