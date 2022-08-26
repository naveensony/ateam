@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Events') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <button style="margin-bottom: 10px;float:right" class="btn btn-success add" data-toggle="modal" data-target="#myModal" >Add Event </button>
                    <table class="table table-bordered data-table">
                        <tr>
                                
                                <th width="80px">No</th>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Add Invitee</th>
                                <th>View Invitee</th>
                                <th width="100px">Delete</th>
                            </tr>
                            @if($events->count())
                                @foreach($events as $key => $event)
                                    <tr id="tr_{{$event->id}}">
                                        
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $event->name }}</td>
                                        <td>{{ $event->start_date }}</td>
                                        
                                        <td>{{ $event->end_date }}</td>
                                        <td><a  class="add_invitee" data-id="{{$event->id}}" data-toggle="modal" data-target="#add_invitee_Modal" >Add </a></td>
                                        <td><a  class="view_invitee" data-id="{{$event->id}}" data-toggle="modal" data-target="#view_invitee_Modal" >View </a></td>
                                        <td>
                                            <a href="{{route('event.delete',$event->id)}}" class="btn btn-danger btn-sm ">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                    </table>
                </div>
            </div>
        </div>

                    <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Event</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form >
      <div class="alert alert-success" id="success-alert" style="display:none">Event added sucessfully</div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name"  required>
                <div id="error_name" style="display:none" class="invalid-feedback" style="color:red"></div>
                
            </div>
            <div class="form-group">
                <label for="price">Start Date</label>
                <input type="date" class="form-control" id="start_date" >
                <div id="error_start_date" style="display:none" class="invalid-feedback" style="color:red"></div>
            </div>

            <div class="form-group">
                <label for="price">End Date</label>
                <input type="date" class="form-control" id="end_date" >
                <div id="error_end_date" style="display:none" class="invalid-feedback" style="color:red"></div>
            </div>
            
            
            <a onclick="submitaddform()" class="btn btn-primary">Submit</a>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

    <!-- The add Modal -->
    <div class="modal" id="add_invitee_Modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Invitee</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form >
      <div class="alert alert-success" id="success-alert-invitee" style="display:none">Invitee added sucessfully</div>
            <div class="form-group">
                <label for="invitee_email">Email</label>
                <input type="email" class="form-control" id="invitee_email"  required>
                <input type="hidden" class="form-control" id="invitee_event"  required>
                <div id="error_invitee_email" style="display:none" class="invalid-feedback" style="color:red"></div>
                
            </div>
            
            
            
            <a onclick="submitinviteeaddform()" id="invitee_add_model_button" class="btn btn-primary">Submit</a>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- The add Modal -->
<div class="modal" id="view_invitee_Modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">View Invitee</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form >
      <div class="alert alert-success" id="success-alert-invitee-delete" style="display:none">Invitee deleted sucessfully</div>
      
      
                <table class="table" id="view_invitee_table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Delete</th>
                
                </tr>
            </thead>
            <tbody>
                
            </tbody>
            </table>


        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



       

<script type="text/javascript">
    $(document).ready(function () {
        
        
            $('body').on('click', 'a.inv_delete', function(e) {
            var id = $(this).attr('data-id');
            $(this).closest('tr').remove();
            $.ajax({
                        url: "/invitation/delete/"+id,
                        type: 'get',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                       
                        success: function (data) {
                            
                            $("#success-alert-invitee-delete").show();
                            setTimeout(function() { $("#success-alert").hide(); }, 5000);
                            //location.reload();
                            
                            
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
        });

        $('.view_invitee').on('click', function(e) {
            
            var id = $(this).attr('data-id');
            $.ajax({
                        url: "/invitation/"+id,
                        type: 'get',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                       
                        success: function (data) {
                            $("#view_invitee_table  tbody").html("");
                            $("#view_invitee_table tbody").append(data);
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
        });
        
        $('.add_invitee').on('click', function(e) {
            var id = $(this).attr('data-id');
            $('#invitee_event').val(id) ; 
        });
        $("#invitee_email").keyup(function(){
            var event = $('#invitee_event').val(); 
            var email = $('#invitee_email').val();
            var fd = new FormData();
            
            fd.append('event',event);
            fd.append('email',email);
            
            $.ajax({
                        url: "/invitation/check",
                        type: 'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        processData: false,
                        contentType: false,
                        data:fd,
                        success: function (data) {
                           // console.data;
                           if (data['success']) {
                                
                                document.getElementById('invitee_add_model_button').style.pointerEvents = 'none';
                                $("#error_invitee_email").text("Invitee already exists.")
                                $("#error_invitee_email").show();
                                setTimeout(function() { $("#error_invitee_email").hide(); }, 4000);
                            }
                            else{
                                document.getElementById('invitee_add_model_button').style.pointerEvents = 'auto';
                            }
                            // if (data['success']) {
                                
                            //     alert(data['success']);
                            //     location.reload();
                            // } else if (data['error']) {
                            //     alert(data['error']);
                            // } else {
                            //     alert('Whoops Something went wrong!!');
                            // }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
        });
        
        $('.delete_single').on('click', function(e) {
            id = $(this).attr('data-idd');
            $.ajax({
                        url: '/home/delete/'+id,
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        
                        success: function (data) {
                            if (data['success']) {
                                
                                alert(data['success']);
                                location.reload();
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });

        });

        


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
    });

    function submitaddform()
        {

            
            var name = $('#name').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
         
            
           
            if(name == '')
            {
                $("#error_name").text("Please enter the name")
                $("#error_name").show();
                setTimeout(function() { $("#error_name").hide(); }, 4000);
                return false
            }
            else if(start_date == '')
            {
                $("#error_start_date").text("Please select the start date")
                $("#error_start_date").show();
                setTimeout(function() { $("#error_start_date").hide(); }, 4000);
                return false
            }
            else if(end_date == '')
            {
                $("#error_end_date").text("Please select the end date")
                $("#error_end_date").show();
                setTimeout(function() { $("#error_end_date").hide(); }, 4000);
                return false
            }
            else if(new Date(start_date) > new Date(end_date))
            {
                $("#error_end_date").text("Please select the end date greater than start date")
                $("#error_end_date").show();
                setTimeout(function() { $("#error_end_date").hide(); }, 4000);
                return false
            }
            

            
           

            

            
            var fd = new FormData();
            
            fd.append('name',name);
            fd.append('start_date',start_date);
            fd.append('end_date',end_date);
            


            $.ajax({
                headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
           type:'POST',
           url:"{{route('event.store')}}",
           processData: false,
           contentType: false,
           data:fd,
           success:function(data){
            $("#success-alert").show();
            setTimeout(function() { $("#success-alert").hide(); }, 5000);
            location.reload();
           }
        });
            
        }

       function submitinviteeaddform()
       {
            var event = $('#invitee_event').val(); 
            var email = $('#invitee_email').val();
            
            if(email == '')
            {
                $("#error_invitee_email").text("Please enter the email")
                $("#error_invitee_email").show();
                setTimeout(function() { $("#error_invitee_email").hide(); }, 4000);
                return false
            }
            else if(IsEmail(email)==false)
            {
                $("#error_invitee_email").text("Please enter a valid email")
                $("#error_invitee_email").show();
                setTimeout(function() { $("#error_invitee_email").hide(); }, 4000);
                return false
            }
            var fd = new FormData();
            
            fd.append('event_id',event);
            fd.append('email',email);
            
            $.ajax({
                        url: "/invitation/store",
                        type: 'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        processData: false,
                        contentType: false,
                        data:fd,
                        success: function (data) {
                            
                            $("#success-alert-invitee").show();
                            setTimeout(function() { $("#success-alert-invitee").hide(); }, 5000);
                            location.reload();
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
        
       }

       function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
            return false;
        }else{
            return true;
        }
        }
</script>

@endsection
