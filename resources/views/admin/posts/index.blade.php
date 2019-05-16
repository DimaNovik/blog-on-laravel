@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Керування сторінкою - Новини
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            {{ Form::open(['route' => 'posts.store', 'files' => true]) }}
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Новини</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('posts.create')}}" class="btn btn-success">Додати</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Назва</th>
                            <th>Стислий зміст</th>
                            <th>Картинка</th>
                            <th>Статус</th>
                            <th>Дії з постом</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->description}}</td>
                            <td>
                                <img src="{{$post->getImage()}}" alt="" width="100">
                            </td>
                            <td>{{$post->status}}</td>
                            <td><a href="{{route('posts.edit', $post->id)}}" class="fa fa-pencil"></a>
                                {{Form::open(['route'=>['posts.destroy', $post->id], 'method'=>'delete'])}}
                                <button class="delete" onclick="return confirm('Вы уверены в удалении материала?')">
                                    <i class="fa fa-remove"></i>
                                </button>
                                {{Form::close()}}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            {{Form::close()}}

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection