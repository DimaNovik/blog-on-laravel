@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Сторінка редагування статті
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            {{Form::open([
                'route' => ['documents.update', $document->id],
                'files' => true,
                'method' => 'put'
            ])}}
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Редагувати статтю</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Заголовок</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title" value="{{$document->title}}">
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
                        <div class="form-group">
                            <img src="{{$document->getImage()}}" alt="" class="img-responsive" width="200">
                            <label for="exampleInputFile">Оберіть документ</label>
                            <input type="file" id="exampleInputFile" name="file">

                            <p class="help-block">Максимальний розмір файлу 100М..</p>
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

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-warning pull-right">Змінити</button>
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