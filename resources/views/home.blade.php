@extends('layouts.app')

@section('title','Accueil')

@section('content')

    @php
        // l'utilisateur courant
        $user = Auth::getUser();
    @endphp

    @hasanyrole('administrateur|etudiant|enseignant')
     @if(!$user->hasRole("administrateur"))
        @foreach($user->niveaux as $niveau)
            <div class="box" style="width:720px !important">
            <h4 style="font-size:18px;padding-bottom:10px;font-weight:bold;color:#7d2ae7;border-bottom:1px solid #7d2ae7 !important"><a href="/niveau/{{ $niveau->id }}" class="btn btn-primary p-2" style="text-decoration: none"> Niveau {{$niveau->nom}}</a></h4>
                <i class="d-block mt-3 mb-2"><button class="btn" data-toggle="collapse" data-target="#{{ $niveau }}">Liste des matières &gt;</button></i>
                <ul class="collapse list-group w-100" >
                    @foreach($niveau->matieres as $matiere)
                        {{-- TODO: prévoir un lien pour accéder à ce matière (lien /matiere/xx)--}}
                        <li class="list-group-item "> <a href="/matiere/{{$matiere->id}}" class="d-block w-100 h-100">{{$matiere->nom}}</a></li>
                    @endforeach
                </ul>
            </div>
        @endforeach
       @else
       <p class="text-center">
       <p class="text-center">Bienvenue {{$user->name}}</p>
       <p class="text-center">En tant qu'administrateur ,  vous pouvez :</p>
       <ul>
       <li>Assigner des rôles</li>
       <li>Voir la liste des utilisateurs</li>
       <li>Assigner un niveau à un utilisateur</li>
       </ul>

       </p>
       @endif
    @else
    <p class="text-center">Vous êtes enregistré avec succès! Veuillez contacter l'administrateur pour continuer</p>
    {{-- <script  type="text/javascript">window.location = {url('/')};</script> --}}
    @endhasanyrole
@endsection
