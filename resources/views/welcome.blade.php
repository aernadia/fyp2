@include ('layouts.app1')
<!DOCTYPE html>
<html>
</head>
	<title>SFAS</title>
  
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ url('/css/w3.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ url('/css/homecss.css') }}" />

</head>	
<body>

	<div class="w3-content w3-section" style="max-width:1550px">
		

		<img class="mySlides w3-animate-fading" src="https://i.ytimg.com/vi/kvmIhf7PCHs/maxresdefault.jpg" style="width:100%">
        <img class="mySlides w3-animate-fading" src="https://i.ytimg.com/vi/kvmIhf7PCHs/maxresdefault.jpg" style="width:100%">
		{{-- <img class="mySlides w3-animate-fading" src="2image.jpg" style="width:100%"> --}}
		{{-- <img class="mySlides w3-animate-fading" src="3image.jpg" style="width:100%"> --}}
		
 
	</div>		
		{{-- <table border="0" width="100%" align="center">
		<tr>
		
			<td>
				<div class="container">
				<a href="{{ url('/admin')}}">
				<button class="button button1">ADMIN</button>
				<img src="blockA.jpg" alt="Avatar" class="image" width="50" height="50"  style="border-radius:15%">
				<div class="overlay">Admin</div>
				</div>
			</td>
			
			<td>
				<div class="container">
				<a href="{{ url('/stud') }}">
				<button class="button button2">STUDENT</button>
				<img src="blockB.png" alt="Avatar" class="image" width="50" height="50"  style="border-radius:15%">
				<div class="overlay">Student</div>
				</div>
			</td>
			
			
			<td>
				<div class="container">
				<a href="supervisor">
				<button class="button button3">SUPERVISOR</button>
				<img src="audiA.jpg" alt="Avatar" class="image" width="50" height="50"  style="border-radius:15%">
				<div class="overlay">Supervisor</div>
				</div>
			</td>
			
			<td>
				<div class="container">
				<a href="lecturer">
				<button class="button button4">LECTURER</button>
				<img src="bsu.jpg" alt="Avatar" class="image" width="50" height="50"  style="border-radius:15%">
				<div class="overlay">Lecturer</div>
				</div>
			</td>
			
		</tr>
		</table> --}}
		

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