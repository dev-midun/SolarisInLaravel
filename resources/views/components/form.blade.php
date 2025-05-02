@props([
    "id",
    "action" => null,
    "method" => "POST",
    "model" => null
])

<form {{ 
    $attributes->merge([
        "id" => $id,
        "method" => $method,
        "action" => $action,
        "model" => $model,
        "solar-ui" => "form"
    ]) 
}}>
    @if (strtoupper($method) != "GET")
    @csrf
    @endif

    @if (!in_array($method, ["POST", "GET"]))
    <input type="hidden" name="_method" value={{ $method }}>
    @endif
    
    {{ $slot }}
</form>