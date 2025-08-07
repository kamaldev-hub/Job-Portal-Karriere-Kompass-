@if (!empty($breadcrumbs))
    <nav aria-label="breadcrumb">
        <ol style="display: flex; list-style: none; padding: 0;">
            @foreach ($breadcrumbs as $crumb)
                @if ($loop->last)
                    <li style="padding-right: 5px;">{{ $crumb->title }}</li>
                @else
                    <li style="padding-right: 5px;">
                        <a href="{{ $crumb->url }}">{{ $crumb->title }}</a> >&nbsp;
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif
