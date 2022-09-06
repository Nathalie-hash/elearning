@extends('layouts.app')

@section ( '{{$matiere->nom}}', 'Matiere')

@section('content')
<div class="container-fluid">
    @if (session('succes'))
        <div class="alert alert-success">
            {{ session('succes') }}
        </div>
    @endif
    <hr>
    <h4>
        Matière : {{$matiere->nom}}
        <a href="/niveau/{{$matiere->niveau_id}}">{{$matiere->niveau->nom}}</a>
    </h4>
    <i>{{$matiere->detail}}</i>

    <hr>
    <br>

    <h4>Ressources</h4>
    {{-- TODO: lister les ressources associés à ce matière ici
    pour chaque ressources, renseigner un lien de téléchargement
    (cf: RessourcesController@getRessource et web.php)
    --}}

    {{-- TODO: à côté du lien de téléchargement, ajouter un lien de
    suppression si l'utilisateur courant a pour rôle enseignant
    ou administrateur --}}
    <table class="table table-hover">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Date de création</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($matiere->ressources()->where('matiere_id',$matiere->id)->get() as $m)
            <tr>
                <td> {{ $m->nom }} </td>
                <td> {{ $m->created_at }} </td>
                <td>
                    <a href="/ressources/get/{{ $m->id }}">
                        télécharger
                    </a>
                    @if($user->hasRole('administrateur') || $user->hasRole('enseignant'))
                        <a href="/ressources/delete/{{ $m->id }}">
                            supprimer
                        </a>
                    @endif
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    {{-- TODO: ne pas afficher cette partie pour ajouter les ressources si
    le rôle de l'utilisateur courant est différent d'enseignant ou d'administrateur
    --}}
    @php
    // l'utilisateur courant
    $user = Auth::getUser();

    @endphp
    @if(!auth()->user()->hasRole("etudiant"))
        <h4>Ajouter ressources</h4>
        <form action="/ressources/add" enctype="multipart/form-data" method="post">
            {{-- TODO: rappel : toujours ajouter cet input _token dans les formulaires. Ici OK --}}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="file" name="ressource"  id="">
            <input type="hidden" name="matiere" value="{{$matiere->id}}">
            <input type="submit" class="btn btn-info" value="téléverser">
        </form>
    @endif
</div>
@endsection
