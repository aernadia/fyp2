<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SFAS</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
  </head>
  <body>
  <form method="POST" action="{{route('admin.users.updatedropdown',$user)}}" enctype="multipart/form-data">
    @method('PUT')
    @csrf()
    <div class="container">
    <h2>Key in Maximum Quota</h2>
            <div class="form-group">
                <label for="maxquota">Select Quota:</label>
                <select name="maxquota" class="form-control" style="width:250px">
                    {{-- <option value="0" selected>--- Select Number ---</option> --}}
                    <option value="0" {{$user->maxquota==0 ? 'selected' : ''}}>--- Select Number --</option>
                    <option value="1" {{$user->maxquota==1 ? 'selected' : ''}}>1</option>
                    <option value="2" {{$user->maxquota==2 ? 'selected' : ''}}>2</option>
                    <option value="3" {{$user->maxquota==2 ? 'selected' : ''}}>3</option>
                    <option value="4" {{$user->maxquota==2 ? 'selected' : ''}}>4</option>
                    <option value="5" {{$user->maxquota==2 ? 'selected' : ''}}>5</option>
                    <option value="6" {{$user->maxquota==2 ? 'selected' : ''}}>6</option>
     
                </select>
                
                <div class="form-group pt-2">
                    <input class="btn btn-primary" type="submit" value="Submit">
                </div>
            </div>
      </div>
    </form>
  </body>
</html>