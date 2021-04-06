<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td>
                <table width="500" align="center" border="0.5" cellspacing="0" cellpadding="5">
                    <thead>
                        <tr>
                            <td colspan="2">
                                <p style="margin: 0; padding: 0;" align="center">КВИТАНЦІЯ</p>
                            </td>
                        </tr>
                    </thead>
                    <tr>
                        <td>
                            <p style="margin: 0; padding: 0;">ПІБ замовника-платника нотаріальної послуги</p>
                        </td>
                        <td>
                            <p style="margin: 0; padding: 0;" align="center">{{$fio}}; {{$inn}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0; padding: 0;">Отримувач</p>
                        </td>
                        <td>
                            <p style="margin: 0; padding: 0;" align="center">Південне міжрегіональне управління Міністерства юстиції (м. Одеса)</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0; padding: 0;">Код ЄДРПОУ</p>
                        </td>
                        <td>
                            <p style="margin: 0; padding: 0;" align="center">43315529</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0; padding: 0;">МФО</p>
                        </td>
                        <td>
                            <p style="margin: 0; padding: 0;" align="center">820172</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0; padding: 0;">Банк отримувача</p>
                        </td>
                        <td>
                            <p style="margin: 0; padding: 0;" align="center">Держказначейська служба України, м. Київ</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0; padding: 0;">Номер рахунку (IBAN)</p>
                        </td>
                        <td>
                            <p style="margin: 0; padding: 0;" align="center">UA318201720313271002201159830 (спецфонд)</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0; padding: 0;">Загальна сума</p>
                        </td>
                        <td>
                            <p style="margin: 0; padding: 0;" align="center">{{$price}} грн.</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0; padding: 0;">Призначення платежу</p>
                        </td>
                        <td>
                            <p style="margin: 0; padding: 0;" align="center">{{$code}} {{$fio}} (за додаткові платні послуги)</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>