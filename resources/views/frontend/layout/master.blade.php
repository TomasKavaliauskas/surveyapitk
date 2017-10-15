<!DOCTYPE html>
<html lang="en">
  <head>
	
	@include('frontend.common.head')

  </head>
  <body>
  
	@include('frontend.common.header')
	
	@yield('content')
	
	@include('frontend.common.footer')

  </body>
</html>