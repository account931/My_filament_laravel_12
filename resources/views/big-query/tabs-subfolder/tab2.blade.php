    {{-- BigData display 2 most viewed products --}}
    <div class="container mt-4">
        <h2 class="mb-3">BigData display 2 most viewed products</h2>

        <table class="table table-bordered table-striped align-middle">
            <thead class="thead-dark">
                <tr>
                    <th>Product ID</th>
                    <th>Product Name </th>
                    <th>Count Views</th>


                </tr>
            </thead>
            <tbody>
                @forelse ($topTwoViewed as $view)
                    <tr>
                        <td>{{ $view['product_id'] }}</td>
                        <td>{{ $view['product']['name'] ?? 'Unknown Product' }}</td>
                        <td>{{ $view['total_views'] }}</td>
                    
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No top 2 viewed products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- End BigData display 2 most viewed products --}}

