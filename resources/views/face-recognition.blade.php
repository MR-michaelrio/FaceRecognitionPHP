@extends('layout.template')

@section('title')
    Table Owner
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if(isset($result['matches']) && count($result['matches']) > 0)
            <p>Matches: {{ implode(', ', $result['matches']) }}</p>
            <p>Face: {{ $result['face'] }}</p>
        @else
            <p>Error: {{ $result['face'] }}</p>
        @endif
        </div>
</div>  
@if($message == 'Face recognized!')
    <script>
        Swal.fire({
        title: "{{ $message }}",
        icon: "success",
        confirmButtonText: "OK"
        }).then(function() {
            window.location.assign('/absen');
        });;
    </script>
@else
    <script>
        Swal.fire({
        title: "{{ $message }}",
        icon: "error",
        confirmButtonText: "OK"
        }).then(function() {
            window.location.assign('/absen');
        });;
    </script>
@endif
 
@endsection