@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <a href="/new-project">Create New Project</a>
        <br>
        <a href="/myprojects">My Project</a>
        <br>

        <div class="col-md-8">
            <h1>Projekti na kojima ste voditelj</h1>

            @foreach ($projects as $project)
            <hr>
            <div>
                <h2>{{ $project->naziv_projekta }} <a href="{{ route('editproject', $project->naziv_projekta) }}">Edit</a></h2>
                <p>{{ $project->opis_projekta }}</p>
                <p>{{ $project->cijena_projekta }}</p>
                <p>{{ $project->obavljeni_poslovi }}</p>
                <p>{{ $project->datum_pocetka }}</p>
                <p>{{ $project->datum_zavrsetka }}</p>
            </div>
            @endforeach
        </div>

        <div class="col-md-8">
            <h1>Projekti na kojima ste sudionik</h1>

            @foreach ($projects_participant as $project)
            <hr>
            <div>
                <h2>{{ $project->naziv_projekta }} <a href="{{ route('editproject', $project->naziv_projekta) }}">Edit</a></h2>
                <p>{{ $project->opis_projekta }}</p>
                <p>{{ $project->cijena_projekta }}</p>
                <p>{{ $project->obavljeni_poslovi }}</p>
                <p>{{ $project->datum_pocetka }}</p>
                <p>{{ $project->datum_zavrsetka }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
