@extends('layout.app')

@section('content')

	<div class="content">
		<div class="container">
			<h1>Posts</h1>
			
			

			@if(count($posts) > 0)

			<div class="row container">
			    @foreach($posts as $post)

			  <div class="col-sm-4">
			  
			  <div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">{{$post->firstname}}  {{$post->lastname}}</h3>
			  </div>
			  <div class="panel-body">
			    <h2> {{$post->subject}}</h2> 

			    <img src="/storage/post_image/{{$post->post_image}}" class="img-thumbnail center-block img-responsive" alt="{{$post->post_image}}" style="width:100%;height:300px; " >

			    <span class="label label-danger">created at : {{$post->created_at}}  </span>
				<span class="label label-info"> BY {{$post->user->name}}  </span>

			    <a href="/posts/{{$post->id}}" class="pull-right btn btn-success">More</a>
			    

			  </div>
			</div> 

	

		</div>
@endforeach 
	</div>
{{$posts->links()}}
@else


<div class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Oh  !</strong> <a href="#" class="alert-link">No posts !</a> and try submitting again.
</div>



@endif

@endsection