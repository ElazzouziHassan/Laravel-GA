<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>gestion des activites</title>
</head>
<body>

    <h1>Liste des activités</h1>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Durée</th>
                <th>Difficulté</th>
                <th>Âge maximum</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activites as $activite)
                <tr>
                    <td>{{ $activite->titre }}</td>
                    <td>{{ $activite->description }}</td>
                    <td>{{ $activite->duree }}</td>
                    <td>{{ $activite->difficulte }}</td>
                    <td>{{ $activite->age_max }}</td>
                    <td>
                        <a href="{{ route('edit', $activite->id) }}">Modifier</a>
                        <form action="{{ route('destroy', $activite->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('create') }}">Ajouter une activité</a>

</body>
</html>