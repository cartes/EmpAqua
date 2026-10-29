<table width="600" cellspacing="0" cellpadding="0" align="center" style="background-color: #ffa73b;">
    <tr>
        <td align="center" style="padding: 20px;">
            <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="background-color: #ffffff; border-radius: 4px; border-collapse: separate;">
                <tr>
                    <td align="center" style="padding: 35px 30px 5px;">
                        <h1>{{ $title }}</h1>
                        @isset($lines)
                            @foreach ($lines as $label => $value)
                                <h4>{{ $label }}: {{ $value }}</h4>
                            @endforeach
                        @endisset
                        @isset($link)
                            <p>Haz click en el siguiente link</p>
                            <p><a href="{{ $link }}">{{ $linkText ?? 'Continuar' }}</a></p>
                        @endisset
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
