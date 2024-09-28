@php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container mt-3 border ps-2 pe-2"> <!-- changed to container-fluid -->
        <div class="row">

            <div>
                <h2>{{ $data['title'] }}</h2>
                <div class="row g-2 mb-3"> <!-- Changed from d-flex gap to row g-2 for proper alignment -->

                    <a href="{{ route('generate-pdf') }}" class="btn btn-secondary col-12 col-md-2">Download Pdf</a>
                    <a href="{{ route('export-csv') }}" class="btn btn-secondary col-12 col-md-2">Download Csv</a>
                    <a href="{{ route('export-docx') }}" class="btn btn-secondary col-12 col-md-2">Download Docx</a>
                    <a href="{{ route('export-excel') }}" class="btn btn-secondary col-12 col-md-2">Download Excel</a>
                    <a href="{{ route('export-json') }}" class="btn btn-secondary col-12 col-md-2">Download JSON</a>
                    <a href="{{ route('export-xml') }}" class="btn btn-secondary col-12 col-md-2">Download XML</a>
                </div>
            </div>

            <!-- Search Form -->
            <div class="row g-2 mb-2">
                <div class="col-4 col-md-4 mb-2">
                    <a href="{{ route('about-us') }}" class="btn btn-info w-100">About</a>
                </div>
                <div class="col-4 col-md-4">
                    <form action="{{ route('index') }}" method="GET" id="dateFilterForm">
                        <!-- <label for="date">Select Date:</label> -->
                        <select name="date" id="date" class="form-select" onchange="this.form.submit()">
    <option value="">-- Select a Date --</option>
    <option value="today">Today</option>
    <option value="yesterday">Yesterday</option>
    <option value="two_days_ago">Two Days Ago</option>
</select>

                    </form>
                </div>
                <div class="col-4 col-md-4">
                    <form id="searchForm" action="{{ route('search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="query" id="searchInput" class="form-control"
                                placeholder="Search..." value="{{ request()->input('query') }}">
                            <button class="btn btn-secondary" type="submit" id="searchButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Display Search Results -->
            @if(isset($clients) && $clients->isEmpty())
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Company Name</th>
                    <th>Address</th>
                    <th>created_at</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center">Data Not Available</td>
                </tr>
            </tbody>
        </table>
    </div>
    @if(request()->has('query'))
        <script>
            setTimeout(function () {
                window.location.href = "{{ route('index') }}";
            }, 5000); 
        </script>
    @endif
@else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Company Name</th>
                    <th>Address</th>
                    <th>created_at</th>
                </tr>
            </thead>
            <tbody>
                @php $index = ($clients->currentPage() - 1) * $clients->perPage(); @endphp
                @foreach ($clients as $client)
                    @php $index++; @endphp
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $client->first_name }} {{ $client->last_name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone_number }}</td>
                        <td>{{ $client->company_name }}</td>
                        <td>{{ $client->address }}</td>
                        <td>{{ $client->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif


            <!-- Pagination Links -->
            <div class="pagination-wrapper">
                {{ $clients->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const query = urlParams.get('query');
            if (query === "") {
                alert("Please enter a search term.");
            }
  
        });
    </script>
    <script>
    
    setTimeout(() => {
        const url = new URL(window.location.href);
        url.searchParams.delete('date'); 
        window.history.pushState({}, document.title, url);
        location.reload();
    }, 10000); 

    document.getElementById('date').addEventListener('change', function() {
        if (this.value) {
            this.form.submit();
        } else {
            clearUrlAndReload();
        }
    });
    
</script>
    
</body>

</html>