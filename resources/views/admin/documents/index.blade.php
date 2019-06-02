@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Керування сторінкою - Документи
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            {{ Form::open(['route' => 'documents.store', 'files' => true]) }}
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Документи</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('documents.create')}}" class="btn btn-success">Додати</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Назва</th>
                            <th>Категорія</th>
                            <th>Докумени</th>
                            <th>Статус</th>
                            <th>Дії з документом</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($documents as $document)
                        <tr>
                            <td>{{$document->id}}</td>
                            <td>{{$document->title}}</td>
                            <td>{{$document->category}}</td>
                            <td>{!! $document->file !!}</td>
                            <td>{{$document->status}}</td>
                            <td><a href="{{route('documents.edit', $document->id)}}" class="fa fa-pencil"></a>
                                {{Form::open(['route'=>['documents.destroy', $document->id], 'method'=>'delete'])}}
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