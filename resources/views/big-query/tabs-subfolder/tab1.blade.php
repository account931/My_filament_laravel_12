    {{-- BigData display of Last 5 viewed products --}}
    <div class="container mt-4">
        <h2 class="mb-3">Last 5 Viewed Products</h2>

        <table class="table table-bordered table-striped align-middle">
            <thead class="thead-dark">
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Viewed At</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($viewsLastFive as $view)
                    <tr>
                        <td>{{ $view['product_id'] }}</td>
                        <td>{{ $view['product']['name'] ?? 'Unknown Product' }}</td>
                        <td>{{ $view['user_id'] }}</td>
                        <td>{{ $view['user']['name'] ?? 'Unknown User' }}</td>
                        <td>
                            {{ $view['viewed_at'] instanceof \DateTimeInterface 
                                ? $view['viewed_at']->format('Y-m-d H:i:s') 
                                : $view['viewed_at'] }}
                        </td>
                        <td>{{ $view['ip_address'] }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($view['user_agent'], 40) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No viewed products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- End BigData display of Last 5 viewed products --}}

    

