<div>
    <h2 class="text-lg font-bold mb-2">{{ $response['title'] ?? 'No title' }}</h2>
    <p>{{ $response['body'] ?? 'No body content' }}</p>
    <pre class="text-sm bg-gray-100 p-4 rounded">{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>

</div>
