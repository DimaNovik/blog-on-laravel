@extends('admin.layout')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Додати документ
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            {{Form::open(['route' => 'documents.store', 'files' => true])}}
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Додати документ</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Заголовок</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title" value="{{old('title')}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Категорія документа</label>
                            <select name="category" id="category_id" class="form-control select2">
                                <option value="0">Оберіть категорію документа</option>
                                <option value="1">Доручення та інформація відділу нотаріату</option>
                                <option value="2">Інформаційні листи</option>
                                <option value="3">Методичні вказівки, рекомендації</option>
                                <option value="4">Узагальненні нотаріальної практики</option>
                                <option value="5">Накази Головного управління юстиції в Одеській області</option>
                                <option value="6">Перелік втрачених паспортів</option>
                            </select>
                        </div>
                        <!-- checkbox -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal" name="status">
                            </label>
                            <label>
                                Чернетка
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Текст</label>
                            <textarea cols="30" rows="10" class="form-control" name="file" id="file">{{old('file')}}</textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-default">
                        <a href="{{route('posts.index')}}">Назад</a></button>
                    <button class="btn btn-success pull-right">Додати</button>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
            {{Form::close()}}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection