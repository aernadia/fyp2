@include ('layouts.app1')
<!DOCTYPE html>
<html>
</head>
	<title>SFAS</title>
  
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{{-- <link rel="stylesheet" type="text/css" href="{{ url('/css/w3.css') }}" /> --}}
	{{-- <link rel="stylesheet" type="text/css" href="{{ url('/css/homecss.css') }}" /> --}}

</head>	
<body>

	<div class="w3-content w3-section" style="max-width:1550px">
		

		<img class="mySlides w3-animate-fading" src="https://i.ytimg.com/vi/kvmIhf7PCHs/maxresdefault.jpg" style="width:100%">
		
{{--  
	</div>		
		<table border="0" width="100%" align="center">
		<tr>
	
			<td>
				<div class="container">
				<a href="/about">
				<button class="button button3">SUPERVISOR</button>
				</div>
			</td>
			
			<td>
				<div class="container">
				<a href="/contact">
				<button class="button button4">LECTURER</button>
				</div>
			</td>
			
		</tr>
		</table>
	</div> --}}
		

	<script>
		var myIndex = 0;
		carousel();

		function carousel() {
		var i;
		var x = document.getElementsByClassName("mySlides");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";  
		}
	
			myIndex++;
			if (myIndex > x.length) {myIndex = 1}    
			x[myIndex-1].style.display = "block";  
			setTimeout(carousel, 9000);    
		}
	</script>

</body>
</html>