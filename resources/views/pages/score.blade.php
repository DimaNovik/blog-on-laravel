<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body {
            font-family: 'Times New Roman', DejaVu Sans, serif;
        }

        .container {
            width: 640px;
            max-width: 100%;
            margin: 0 auto;
        }

        .header {

        }

        .header__title {
            margin-bottom: 30px;
        }


    </style>
</head>
<body>

<div class="container">

    <header class="header">
        <div class="header__title">
            <h2 style="font-size: 13px;" align="center">Форма обліку послуг за Розмірами плати за надання державними
                нотаріусами Одеської області додаткових послуг
                правового характеру, які не пов'язані із вчинюваними нотаріальними діями, а також послуг технічного
                характеру</h2>
        </div>
    </header>

    <table cellpadding="3" cellspacing="0" border="1" width="100%">
        <thead>
        <tr>
            <td width="5">
                <p style="font-size: 10px; margin: 0;padding: 0" align="center"><b>Код послуги</b> (пп., п. глава, розділ Розмірів плати)</p>
            </td>
            <td width="60">
                <p style="font-size: 10px;  margin: 0;padding: 0" align="center"><b>Назва послуги</b></p>
            </td>
            <td width="30">
                <p style="font-size: 10px;  margin: 0;padding: 0" align="center"><b>Розмір плати</b> (сума, грн. (за одну послугу))</p>
            </td>
            <td width="35">
                <p style="font-size: 10px;  margin: 0;padding: 0" align="center"><b>Кількість наданих послуг</b></p>
            </td>
            <td width="10">
                <p style="font-size: 10px;  margin: 0;padding: 0" align="center"><b>Загальна сума, грн.</b></p>
            </td>
        </tr>
        </thead>
        <tbody>

        @foreach ($data as $value)
            <tr>
                <td>
                    <p style="font-size: 11px;  margin: 0;padding: 0" align="center">{{$value['code']}}</p></td>
                <td>
                    <p style="font-size: 11px;  margin: 0;padding: 0" align="justify">{{$value['name']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 11px;  margin: 0;padding: 0">{{$value['price']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 11px;  margin: 0;padding: 0">{{$value['count']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 11px;  margin: 0;padding: 0">{{$value['all']}}</p>
                </td>
            </tr>
        @endforeach

        <tr>
            <td align="left" colspan="3">
                <p style="font-size: 11px;  margin: 0;padding: 0"><b>Всього:</b></p>
            </td>
            <td colspan="2">
                <p style="font-size: 11px;  margin: 0;padding: 0"><b>{{$value['total']}}</b></p>
            </td>
        </tr>

        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 13px;">«____» ______________ 20 __ року</p>
    <p style=" font-size: 13px;">Державний нотаріус<span style="display: inline-block; margin-left: 200px;">_______________</span><span
                style="display: inline-block; margin-left: 30px;">___________</span></p>
    <p style=" font-size: 13px;"><span style="display: inline-block; margin-left: 360px;">(підпис)</span><span
                style="display: inline-block; margin-left: 80px;">(П.І.Б)</span></p>
    <p style="margin-top: 30px; text-indent: 35px; font-size: 13px;">Умови оплати та вартість послуг згідно з Розмірами плати мені
        державним
        нотаріусом роз’яснено.</p>
    <p style="margin-top: 30px; font-size: 13px;">«____» ______________ 20 __ року</p>
    <p style=" font-size: 13px;"><span style="display: inline-block; margin-left: 280px;">_______________</span><span
                style="display: inline-block; margin-left: 30px;">___________</span></p>
    <p style=" font-size: 13px;"><span style="display: inline-block; margin-left: 300px;">(підпис)</span><span
                style="display: inline-block; margin-left: 80px;">(П.І.Б)</span></p>
</div>
</body>
</html>