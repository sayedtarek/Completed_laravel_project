@extends('layout.app')
           
           
        @section('content')
         <div class="panel panel-info container">
  <div class="panel-heading">
    <h3 class="panel-title">{{$post->firstname}} - {{$post->lastname}}
   
   
    </h3></div>
      @if(!Auth::guest())
        @if(auth()->user()->id == $post->user_id)
        	<a href="/posts/{{$post->id}}/edit" class="pull-right btn btn-warning">Edit</a>


              <div class="panel-body">

              	{!! Form::open(['action' => ['PostsController@destroy',$post->id]]) !!}
              	{{ Form::hidden('_method','DELETE') }}
        		{{ Form::submit('Delete',['class' =>"pull-right btn btn-danger btn-lg"]) }}

              	{!! Form::close() !!}
          @endif
        @endif

      	<h2> {{$post->subject}}</h2> 

        <img src="/storage/post_image/{{$post->post_image}}" class="img-thumbnail center-block img-responsive" alt="{{$post->post_image}}" style="width:50%;height:50%; " >

     <p> {!!$post->body!!}</p>
   <span class="label label-danger">created at : {{$post->created_at}}</span>
   <span class="label label-info"> BY {{$post->user->name}}  </span>
 

  </div>
  <a class="pull-right" href="/posts" class="btn btn-warning">Back</a>
</div>
@endsection