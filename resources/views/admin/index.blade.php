@extends('admin.layouts.dashboard')

@section('content')

    <div class="row py-lg-2">
        <div class="col-md-6" >
            <h2>Welcome to SFAS</h2>
        </div>
        {{-- @cannot('isManager')
            @can('create', App\Post::class)
            <div class="col-md-6">
                <a href="/posts/create" class="btn btn-primary btn-lg float-md-right" role="button" aria-pressed="true">New Application</a>
            </div>
            
            @endcan
        @endcannot --}}
    </div>

    
    <!-- delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">Select "delete" If you really want to delete this post.</div>
            <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <form method="POST" action="/posts/">
                @method('DELETE')
                @csrf
                <input type="hidden" id="post_id" name="post_id" value="">
                <a class="btn btn-primary" onclick="$(this).closest('form').submit();">Delete</a>
            </form>
            </div>
        </div>
        </div>
    </div>
</div>
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

@endsection

@section('js_post_page')
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var post_id = button.data('postid') 
            
            var modal = $(this)
            modal.find('.modal-footer #post_id').val(post_id);
            modal.find('form').attr('action','/posts/' + post_id);
        })
    </script>
@endsection