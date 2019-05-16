@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Керування сторінкою - Сторінки
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            {{ Form::open(['route' => 'posts.store', 'files' => true]) }}
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Сторінки</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('pages.create')}}" class="btn btn-success">Додати</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Назва</th>
                            <th>Slug</th>
                            <th>Стислий зміст</th>
                            <th>Статус</th>
                            <th>Дії зі сторінкою</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td>{{$page->id}}</td>
                            <td>{{$page->title}}</td>
                            <td>{{$page->slug}}</td>
                            <td>{!! $page->content !!}</td>
                            <td>{{$page->status}}</td>
                            <td><a href="{{route('pages.edit', $page->id)}}" class="fa fa-pencil"></a>
                                {{Form::open(['route'=>['pages.destroy', $page->id], 'method'=>'delete'])}}
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