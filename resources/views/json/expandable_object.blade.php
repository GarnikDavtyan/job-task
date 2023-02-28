@foreach($json as $key => $value)
        <div class="json-item">
            <div class="json-key">{{ $key }}:</div>
            @if(is_array($value))
                <div>
                    <span>[{{isAssoc($value) ? 'object' : 'array'}}]</span>
                    <span class="toggle">+</span>
                    <div class="json-object expandable">
                        @include('json.expandable_object', ['json' => $value])
                    </div>
                </div>
            @else
                <div class="json-value">{{ $value }}</div>
            @endif
        </div>
    @endforeach
