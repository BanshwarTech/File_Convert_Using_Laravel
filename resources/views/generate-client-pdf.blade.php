<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<div>
    <div class="container mt-5">
        <div class="row d-flex">
            <h2>Title:: {{$title}} </h2>
            <h5>Date :: {{$date}}</h5>
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Phone Number</td>
                        <td>Company Name</td>
                        <td>Address</td>
                    </tr>
                </thead>
                <tbody>
                    @php $index = 0;@endphp
                    @foreach ($clientData as $client)
                        @php    $index++; @endphp
                        <tr>
                            <td>{{$index}}</td>
                            <td>{{$client->first_name}} {{$client->last_name}}</td>
                            <td>{{$client->email}}</td>
                            <td>{{$client->phone_number}}</td>
                            <td>{{$client->company_name}}</td>
                            <td>{{$client->address}}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>