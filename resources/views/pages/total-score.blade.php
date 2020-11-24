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

        }

        .container {
            width: 100%;
            height: 100%;
            margin: 0 auto;
            background-image: url(/public/uploads/secure.png); /* Путь к фоновому рисунку */
            background-position: center bottom; /* Положение фона */
            background-repeat: repeat-y; /* Повторяем фон по горизонтали */
        }

        .header__title {
            margin-bottom: 10px;
        }

        table thead {
            display: table-row-group;
        }

        table {
            page-break-inside: auto
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto
        }

        thead {
            display: table-header-group
        }

        tfoot {
            display: table-footer-group
        }
    </style>
</head>
<body>

<div class="container">
    <header class="header">
        <div class="header__title">
            @php

                $i=0;
                foreach($res as $element)
                {

                       if($i!=0)
                          break;
                       $name = (isset($element['userName'])) ? $element['userName'] : '';
                       $group = (isset($element['userGroup'])) ? $element['userGroup'] : '';;
                       $i++;
                }

            @endphp

            <h2 style="font-size: 11px;" align="center">Звіт про роботу державного нотаріуса <br/> {{$name}} <br/> {{$group}}</h2>
        </div>
    </header>

    <table cellpadding="0" cellspacing="0" border="1" width="100%">
        <thead>
        <tr>
            <td>
                <p style="font-size: 11px;" align="center">№ з/п</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Назва послуги</p>
            </td>
            <td width="40">
                <p style="font-size: 11px;" align="center">сума, грн. (за одну послугу)</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Кількість наданих послуг</p>
            </td>
            <td>
                <p style="font-size: 11px;" align="center">Загальна сума, грн</p>
            </td>
        </tr>
        <tr>
            <td align="center"><p style="font-size: 11px; margin: 0;">1</p></td>
            <td align="center"><p style="font-size: 11px; margin: 0;">2</p></td>
            <td align="center" width="80"><p style="font-size: 11px;margin: 0;">3</p></td>
            <td align="center"><p style="font-size: 11px;margin: 0;">5</p></td>
            <td align="center"><p style="font-size: 11px;margin: 0;">6</p></td>
        </tr>
        </thead>
        <tbody>

        @php $count = 0; @endphp;
        @php $count2 = 0; @endphp;
        @php $count3 = 0; @endphp;
        @php $count4 = 0; @endphp;
        @php $count5 = 0; @endphp;

        @foreach ($res as &$value):

        @if($value['subgroup'] == 1):

            @php $count++; @endphp;

            @if($count == 1):
            <tr>
                <td colspan="5" align="center" style="padding: 5px;">
                    <p style="font-size: 12px;margin: 0;"><b>І. Послуги правового характеру, які непов'язані із вчинюваними
                            нотаріальними діями, що
                            надаються державними нотаріусами державних нотаріальних контор та державного нотаріального
                            архіву:</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="5" align="center" style="padding: 5px;">
                    <p style="font-size: 12px;margin: 0;"><b>1.Консультації правового характеру, які непов'язані із
                            вчинюваними нотаріальними діями:</b></p>
                </td>
            </tr>
            @endif

            <tr>
                <td align="center">
                    <p style="font-size: 10px;margin: 0;">{{$value['code']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px;margin: 0;">{{$value['name']}}</p>
                </td>
                <td align="center" width="40">
                    <p style="font-size: 10px;margin: 0;">{{$value['price']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px;margin: 0;">{{$value['count']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px;margin: 0;">{{$value['count'] * $value['price']}}</p>
                </td>
            </tr>

        @elseif($value['subgroup'] == 2):
            @php $count2++; @endphp;

            @if($count2 == 1):
            <tr>
                <td colspan="5" align="center" style="padding: 5px;">
                    <p style="font-size: 12px;margin: 0;"><b>ІІ. Проведення правового аналізу юридичного змісту документів
                            на їх відповідність чинному законодавству за зверненнями фізичних та юридичних осіб</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="5" align="center" style="padding: 5px;">
                    <p style="font-size: 12px;margin: 0;"><b>1. Правовий аналіз документів на предмет відповідності чинному
                            законодавству стосовн</b></p>
                </td>
            </tr>
            @endif

        <tr>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['code']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['name']}}</p>
            </td>
            <td align="center" width="40">
                <p style="font-size: 10px;margin: 0;">{{$value['price']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['count']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['count'] * $value['price']}}</p>
            </td>
        </tr>

        @elseif($value['subgroup'] == 3):
            @php $count3++; @endphp;

            @if($count3 == 1):
            <tr>
                <td colspan="5" align="center" style="padding: 5px;">
                    <p style="font-size: 12px;margin: 0;"><b>IIІ. Послуги інформаційно-технічного характеру, які надаються
                            державними нотаріусами державних нотаріальних контор та державного нотаріального архіву.</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="5" align="center" style="padding: 5px;">
                    <p style="font-size: 12px;margin: 0;"><b>1. Послуга технічного характеру:</b></p>
                </td>
            </tr>
            @endif

        <tr>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['code']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['name']}}</p>
            </td>
            <td align="center" width="40">
                <p style="font-size: 10px;margin: 0;">{{$value['price']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['count']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['count'] * $value['price']}}</p>
            </td>
        </tr>

        @elseif($value['subgroup'] == 4):
            @php $count4++; @endphp;

            @if($count4 == 1):
            <tr>
                <td colspan="5" align="center" style="padding: 5px;">
                    <p style="font-size: 12px;margin: 0;"><b>IIІ. Послуги інформаційно-технічного характеру, які надаються
                            державними нотаріусами державних нотаріальних контор та державного нотаріального архіву.</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="5" align="center" style="padding: 5px;">
                    <p style="font-size: 12px;margin: 0;"><b>1. Інщі послуги:</b></p>
                </td>
            </tr>
            @endif

        <tr>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['code']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['name']}}</p>
            </td>
            <td align="center" width="40">
                <p style="font-size: 10px;margin: 0;">{{$value['price']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['count']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['count'] * $value['price']}}</p>
            </td>
        </tr>
        @elseif($value['subgroup'] == 5):
            @php $count5++; @endphp;

            @if($count5 == 1):
            <tr>
                <td colspan="5" align="center" style="padding: 5px;">
                    <p style="font-size: 12px;margin: 0;"><b>IV. Послуги, які надаються державним нотаріальним архівом як архівною установою:</b></p>
                </td>
            </tr>
            @endif

        <tr>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['code']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['name']}}</p>
            </td>
            <td align="center" width="40">
                <p style="font-size: 10px;margin: 0;">{{$value['price']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['count']}}</p>
            </td>
            <td align="center">
                <p style="font-size: 10px;margin: 0;">{{$value['count'] * $value['price']}}</p>
            </td>
        </tr>
        @endif
        @endforeach


        </tbody>
    </table>
</div>
</body>
</html>