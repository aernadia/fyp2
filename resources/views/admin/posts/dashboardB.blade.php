@extends('admin.layouts.dashboard')

@section('content')

</ul>
<header class="therichpost-container " style="padding-bottom:18px ">
<h1><b><center>MY DASHBOARD<center></b></h1>
</header>
<div class="therichpost-row-padding therichpost-margin-bottom">
  <div class="therichpost-quarter">
    <div class="therichpost-container therichpost-purple therichpost-padding-16">
      <div class="therichpost-left"><i class="fa fa-users therichpost-xxxlarge"></i></div>
      <div class="therichpost-right">
        <h3>{{$sc ?? ''}}</h3>
      </div>
      <div class="therichpost-clear"></div>
      <h4>No. of Supervisors</h4>
    </div>
  </div>
  <div class="therichpost-quarter">
    <div class="therichpost-container therichpost-blue therichpost-padding-16">
      <div class="therichpost-left"><i class="fa fa-users  therichpost-xxxlarge"></i></div>
      <div class="therichpost-right">
        <h3>{{$uc ?? ''}}</h3>
      </div>
      <div class="therichpost-clear"></div>
      <h4>No. of Students</h4>
    </div>
  </div>
  <div class="therichpost-quarter">
    <div class="therichpost-container therichpost-teal therichpost-padding-16">
      <div class="therichpost-left"><i class="fa fa-users therichpost-xxxlarge"></i></div>
      <div class="therichpost-right">
        <h3>{{$u1 ?? ''}}</h3>
      </div>
      <div class="therichpost-clear"></div>
      <h4>Approved Students</h4>
    </div>
  </div>
  <div class="therichpost-quarter">
    <div class="therichpost-container therichpost-orange therichpost-text-white therichpost-padding-16">
      <div class="therichpost-left"><i class="fa fa-user therichpost-xxxlarge"></i></div>
      <div class="therichpost-right">
        <h3>{{$u2 ?? ''}}</h3>
      </div>
      <div class="therichpost-clear"></div>
      <h4>Unavailable Supervisor</h4>
    </div>
  </div>
</div>
<header class="therichpost-container " style="padding-bottom:18px ">
  <h2><b><center>APPLICATION DASHBOARD<center></b></h2>
  </header>
  <div class="therichpost-row-padding therichpost-margin-bottom">
    <div class="therichpost-quarter">
      <div class="therichpost-container therichpost-pink therichpost-padding-16">
        <div class="therichpost-left"><i class="fa fa-sticky-note therichpost-xxxlarge"></i></div>
        <div class="therichpost-right">
          <h3>{{$full ?? ''}}</h3>
        </div>
        <div class="therichpost-clear"></div>
        <h4>No. of Application</h4>
      </div>
    </div>
    <div class="therichpost-quarter">
      <div class="therichpost-container therichpost-green therichpost-padding-16">
        <div class="therichpost-left"><i class="fa fa-hourglass-2  therichpost-xxxlarge"></i></div>
        <div class="therichpost-right">
          <h3>{{$pen ?? ''}}</h3>
        </div>
        <div class="therichpost-clear"></div>
        <h4>Pending Application</h4>
      </div>
    </div>
    <div class="therichpost-quarter">
      <div class="therichpost-container therichpost-red therichpost-padding-16">
        <div class="therichpost-left"><i class="fa fa-close therichpost-xxxlarge"></i></div>
        <div class="therichpost-right">
          <h3>{{$rej ?? ''}}</h3>
        </div>
        <div class="therichpost-clear"></div>
        <h4>Rejected Application</h4>
      </div>
    </div>
    <div class="therichpost-quarter">
      <div class="therichpost-container therichpost-indigo therichpost-text-white therichpost-padding-16">
        <div class="therichpost-left"><i class="fa fa-check therichpost-xxxlarge"></i></div>
        <div class="therichpost-right">
          <h3>{{$app ?? ''}}</h3>
        </div>
        <div class="therichpost-clear"></div>
        <h4>Aproved Application</h4>
      </div>
    </div>
  </div>
<div id="content-wrapper">
    
    <div class="container">
    <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © SFAS Website 2021</span>
          </div>
        </div>
      </footer>
    </div>
    <!-- /.content-wrapper -->
 </div>

 @section('js_user_page')

<script src="/vendor/chart.js/Chart.min.js"></script>
<script src="/js/admin/demo/chart-area-demo.js"></script>

    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var user_id = button.data('userid') 
            
            var modal = $(this)
            // modal.find('.modal-footer #user_id').val(user_id)
            modal.find('form').attr('action','/users/' + user_id);
        })
    </script>

@endsection

@endsection