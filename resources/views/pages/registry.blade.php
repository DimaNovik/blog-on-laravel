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
            width: 900px;
            max-width: 100%;
            margin: 0 auto;
        }

        .header {

        }

        .header__title {
            margin-bottom: 30px;
        }

        @media print {

            table.report { page-break-after:auto }
            table.report tr    { page-break-inside:avoid; page-break-after:auto }
            table.report td    { page-break-inside:avoid; page-break-after:auto }
            table.report thead { display:table-header-group }
            table.report tfoot { display:table-footer-group }
        }

    </style>
</head>
<body>

<div class="container">

    <header class="header">
        <div class="header__title">
            <h2 style="font-size: 11px;" align="center">РЕЄСТР</h2>
            <p align="center" style="font-size: 11px;">обліку додаткових платних послуг правового характеру,<br/> які не пов'язані із вчинюваними нотаріальними
                діями, а також послуг технічного характеру, наданих державним нотаріусом _____________________________________________________________</p>
            <p align="center" style="font-size: 11px; margin: 0; margin-top: -20px; padding-left: 90px">(назва ДНК та ПІБ нотаріуса)</p>
            <p align="center" style="font-size: 11px; margin: 0; margin-top: 20px;">за _________________ 20 __ року</p>
            <p align="center" style="font-size: 10px; margin: 0; margin-left: -40px ">(місяць)</p>
        </div>
    </header>

    <table cellpadding="0" cellspacing="0" border="1" width="100%">
        <thead>
        <tr>
            <td width="5">
                <p style="font-size: 11px;" align="center">№<br/>з/п</p>
            </td>
            <td width="30">
                <p style="font-size: 11px;" align="center">Дата</p>
            </td>
            <td width="15">
                <p style="font-size: 11px;" align="center">Прізвище, ініціали особи, якій надавались послуги</p>
            </td>
            <td width="65">
                <p style="font-size: 11px;" align="center">Види додаткових платних послуг</p>
            </td>
            <td width="10">
                <p style="font-size: 11px;" align="center">№№<br/> квитанцій</p>
            </td>
            <td width="5">
                <p style="font-size: 11px;" align="center">Сума</p>
            </td>
            <td width="5">
                <p style="font-size: 11px;" align="center">Примітка</p>
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
        </tr>
        </thead>
        <tbody>

        @foreach ($data as $key =>  $value)
            <tr>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{++$key}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{substr($value['updated_at'], 0, 10)}}</p>
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
                    <p style="font-size: 10px; margin: 0;">{{$value['code']}}</p>
                </td>
                <td align="center">
                    <p style="font-size: 10px; margin: 0;">{{$value['price']}}</p>
                </td>
                <td></td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
</body>
</html>