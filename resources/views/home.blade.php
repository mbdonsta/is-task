<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test Task</title>
        <style>
            table {
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div>
            @if (!empty($data))
            <table>
                @foreach ($data as $index => $row)
                    <tr>
                        @foreach ($row as $col)
                        <{{ $index === 0 || $index === count($data) - 1 ? 'th' : 'td' }}>{{ $col }}</{{ $index === 0 || $index === count($data) - 1 ? 'th' : 'td' }}>
                        @endforeach
                    </tr>
                @endforeach
            </table>
            @endif
        </div>
    </body>
</html>
