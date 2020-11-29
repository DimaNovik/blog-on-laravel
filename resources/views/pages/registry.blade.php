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
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', DejaVu Sans, serif;
            page-break-before: avoid;

        }

        .container {
            width: 100%;
            height: 100%;
            margin: 0 auto;
            background-image: url(/public/uploads/secure.png); /* Путь к фоновому рисунку */
            background-position: center bottom; /* Положение фона */
            background-repeat: repeat-y; /* Повторяем фон по горизонтали */
        }

        .header {

        }

        .header__title {
            margin-bottom: 30px;
        }



        @page {
            size: A4 landscape;
        }

    </style>
</head>
<body>

<div class="container">

    <header class="header">
        <div class="header__title">
            <h2 style="font-size: 11px;" align="center">РЕЄСТР</h2>
            @if(isset($data[0]['userName']))
            <p align="center" style="font-size: 11px;">обліку додаткових платних послуг правового характеру,<br/> які не пов'язані із вчинюваними нотаріальними
                діями, а також послуг технічного характеру, наданих державним нотаріусом<br/> {{$data[0]['userName']}} ({{$data[0]['userGroup']}})
            </p>
            @else
                <p align="center" style="font-size: 11px;">обліку додаткових платних послуг правового характеру,<br/> які не пов'язані із вчинюваними нотаріальними
                    діями, а також послуг технічного характеру, наданих державними нотаріусами контори: <br/> {{$data[0]['userGroup']}}
                </p>
            @endif
            <p align="center" style="font-size: 11px; margin: 0; margin-top: -10px;">(назва ДНК та ПІБ нотаріуса)</p>
            <p align="center" style="font-size: 11px; margin: 0; margin-top: 20px;">за _________________ 20 __ року</p>
            <p align="center" style="font-size: 10px; margin: 0; margin-left: -40px ">(місяць)</p>
        </div>
    </header>

    <table cellpadding="0" cellspacing="0" border="1" width="100%">
        <thead>
        <tr>
            <td>
                <p style="font-size: 11px;" align="center">№ з/п</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Прізвище,<br/> ініціали особи,<br/> якій<br/> надавались<br/> послуги</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Код<br/> послуги</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Кількість<br/> наданих<br/> послуг</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Сума<br/> сплачених коштів в<br/> звітному місяці,<br/> грн.</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Номер<br/> квитанції<br/> банку про<br/> оплату<br/> послуги</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Дата оплати<br/>послуги<br/> згідно з<br/> квитанцією</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Дата<br/> надання <br/>послуги</p>
            </td>
        </tr>
        <tr>
            <td align="center"><p style="font-size: 11px; margin: 0;">1</p></td>
            <td align="center"><p style="font-size: 11px; margin: 0;">2</p></td>
            <td align="center"><p style="font-size: 11px;margin: 0;">3</p></td>
            <td align="center"><p style="font-size: 11px;margin: 0;">4</p></td>
            <td align="center"><p style="font-size: 11px;margin: 0;">5</p></td>
            <td align="center"><p style="font-size: 11px;margin: 0;">6</p></td>
            <td align="center"><p style="font-size: 11px;margin: 0;">7</p></td>
            <td align="center"><p style="font-size: 11px;margin: 0;">8</p></td>
        </tr>
        </thead>
        <tbody>

        @foreach ($data as $key =>  $value)
            <tr>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{++$key}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{$value['fio']}}</p>
                </td>
                <td align="center">
                    @foreach ($value['actions'] as $item)
                        <p style="font-size: 10px; margin: 0;">{{$item['actions']}}</p>
                    @endforeach
                </td>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{$value['counts']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{$value['price']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{$value['invoice']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{$value['pay_date']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{$value['action_date']}}</p>
                </td>
            </tr>
        @endforeach

        <tr>
            <td align="right" colspan="4" style="padding: 10px;">
                <p style="font-size: 10px; margin: 0; padding-left: 15px"><b>ВСЬОГО:</b></p>
            </td>
            <td align="center">
                <p style="font-size: 10px; margin: 0;"><b>{{$value['total']}}</b></p>
            </td>
            <td colspan="3"></td>
        </tr>


        </tbody>
    </table>

    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 30px">
        <tr>
            <td width="50%">
                @if (empty($data[0]['userName']))
                    <p align="left" style="font-size: 10px;margin: 0;"><b>Нотаріальна контора:</b> <br/> {{$data[0]['userGroup']}}</p>
                @else
                    <p align="left" style="font-size: 10px;margin: 0;"><b>Державний нотаріус:</b> <br/> {{$data[0]['userName']}}</p>
                @endif
            </td>
            <td width="50%">
                <p align="center" style="font-size: 10px;margin: 0;">_______________________</p>
                <p align="center" style="font-size: 10px;margin: 0;">(підпис)</p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>