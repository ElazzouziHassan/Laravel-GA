<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


<h1 class="code-line" data-line-start=0 data-line-end=1 ><a id="1__Crer_le_fichier_de_migration_pour_la_table_activits_0"></a>1 - Créer le fichier de migration pour la table “activités”:</h1>
<h2 class="code-line" data-line-start=1 data-line-end=2 ><a id="_Pour_crer_la_table_activits_dans_la_base_de_donnes_vous_pouvez_utiliser_le_code_suivant_pour_la_migration__1"></a><em>Pour créer la table “activités” dans la base de données, vous pouvez utiliser le code suivant pour la migration:</em></h2>
<pre><code class="has-line-data" data-line-start="3" data-line-end="16" class="language-git">public function up()
    {
        Schema::create('activites', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 80);
            $table->text('description')->nullable();
            $table->unsignedInteger('duree')->default(10);
            $table->unsignedInteger('difficulte');
            $table->unsignedInteger('age_max')->default(1);
            $table->timestamps();
        });
    }
</code></pre>
<h1 class="code-line" data-line-start=17 data-line-end=18 ><a id="Crer_la_factory_pour_la_table_activits_17"></a>Créer la factory pour la table “activités”:</h1>
<h2 class="code-line" data-line-start=18 data-line-end=19 ><a id="Pour_gnrer_des_donnes_fictives_pour_la_table_activits_vous_pouvez_crer_une_factory_en_utilisant_le_code_suivant_18"></a>Pour générer des données fictives pour la table “activités”, vous pouvez créer une factory en utilisant le code suivant:</h2>
<pre><code class="has-line-data" data-line-start="20" data-line-end="32" class="language-git">public function definition(): array
    {
        return [
            // instead of using regex you can use the function : title()
            'titre' => $this->faker->unique()->regexify('[A-Za-z0-9]{1,80}'),
            'description' => $this->faker->text(),
            'duree' => $this->faker->numberBetween(10),
            'difficulte' => $this->faker->numberBetween(1, 5),
            'age_max' => $this->faker->numberBetween(1, 15),
        ];
    }
</code></pre>
<h1 class="code-line" data-line-start=33 data-line-end=34 ><a id="Ajouter_des_donnes_fictives__la_table_activits_dans_le_DatabaseSeeder_33"></a>Ajouter des données fictives à la table “activités” dans le DatabaseSeeder:</h1>
<h2 class="code-line" data-line-start=34 data-line-end=35 ><a id="Dans_la_mthode_run_du_fichier_DatabaseSeeder_vous_pouvez_ajouter_les_dix_activits__la_table_activits_en_utilisant_la_factory_cre_prcdemment_Voici_un_exemple_de_code_34"></a>Dans la méthode run du fichier DatabaseSeeder, vous pouvez ajouter les dix activités à la table “activités” en utilisant la factory créée précédemment. Voici un exemple de code:</h2>
<pre><code class="has-line-data" data-line-start="37" data-line-end="47" class="language-git">public function run(): void
    {
        // !--note! 
        // !You need to make sure that you have created the activites model, 
        // !so you can use it here

        \App\Models\ActivitesModel::factory(10)->create();

    }
</code></pre>
<h1 class="code-line" data-line-start=47 data-line-end=48 ><a id="Activites_Model__47"></a>Activites Model :</h1>
<pre><code class="has-line-data" data-line-start="49" data-line-end="56" class="language-git">class ActivitesModel extends Model
{
    use HasFactory;
    protected $fillable = ['titre' , 'description' , 'duree' , 'difficulte' , 'age_max'];
}

</code></pre>
<h1 class="code-line" data-line-start=57 data-line-end=58 ><a id="Crer_le_contrleur_ActiviteController_pour_les_oprations_CRUD_57"></a>Créer le contrôleur “ActiviteController” pour les opérations CRUD:</h1>
<h2 class="code-line" data-line-start=58 data-line-end=59 ><a id="a__la_fonction_index_58"></a>a - la fonction index:</h2>
<pre><code class="has-line-data" data-line-start="60" data-line-end="66" class="language-git">public function index()
    {
        $activites = ActivitesModel::all();
        return view('index', compact('activites'));
    }
</code></pre>
<h2 class="code-line" data-line-start=66 data-line-end=67 ><a id="b__la_fonction_store_66"></a>b - la fonction store:</h2>
<pre><code class="has-line-data" data-line-start="68" data-line-end="82" class="language-git">public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|unique:activites',
            'difficulte' => 'required|integer|min:1|max:5',
            'duree' => 'required|integer|min:10',
            'age_max' => 'required|integer|min:1|max:15',
        ]);

        ActivitesModel::create($validatedData);

        return redirect()->route('index')->with('success', 'Activité ajoute avec succès.');
    }
</code></pre>
<h2 class="code-line" data-line-start=82 data-line-end=83 ><a id="b__la_fonction_update_82"></a>b - la fonction update:</h2>
<pre><code class="has-line-data" data-line-start="84" data-line-end="98" class="language-git">public function update(Request $request, ActivitesModel $activite)
    {
        $validatedData = $request->validate([
            'titre' => 'required|unique:activites,titre,' . $activite->id . '|regex:/^[A-Za-z0-9\s]+$/',
            'difficulte' => 'required|integer|min:1|max:5',
            'duree' => 'required|integer|min:10',
            'age_max' => 'required|integer|min:1|max:15',
        ]);

        $activite->update($validatedData);

        return redirect()->route('activites.index')->with('success', 'Activité mise à jour avec succès.');
    }
</code></pre>
<h2 class="code-line" data-line-start=99 data-line-end=100 ><a id="b__la_fonction_destroy_99"></a>b - la fonction destroy:</h2>
<pre><code class="has-line-data" data-line-start="101" data-line-end="108" class="language-git">public function destroy(ActivitesModel $activite)
    {
        $activite->delete();

        return redirect()->route('activites.index')->with('success', 'Activité supprimée avec succès.');
    }
</code></pre>

<h2 class="code-line" data-line-start=108 data-line-end=109 ><a id="la_vue_index__108"></a>la vue index :</h2>

```php
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
```

<h1 class="code-line" data-line-start=164 data-line-end=165 ><a id="Installation_164"></a>Installation:</h1>
<h2 class="code-line" data-line-start=165 data-line-end=166 ><a id="To_set_up_the_application_locally_follow_these_steps_165"></a>To set up the application locally, follow these steps:</h2>
<blockquote>
<p class="has-line-data" data-line-start="166" data-line-end="171">1 - Clone the repository from GitHub.<br>
2 - Configure the database connection in the .env file.<br>
3 - Run migrations to create the “activities” table.<br>
4 - Seed the database with sample data using the DatabaseSeeder.<br>
5 - Serve the application using a local development server.</p>
</blockquote>
<p class="has-line-data" data-line-start="173" data-line-end="174">Contributions to this project are welcome. If you encounter any issues or have suggestions for improvements, please open an issue on the GitHub repository. You can also fork the project, make changes, and submit a pull request.</p>
<h2 class="code-line" data-line-start=175 data-line-end=176 ><a id="License_175"></a>License</h2>
<p class="has-line-data" data-line-start="176" data-line-end="179">Wizardy :<br>
<a href="https://github.com/ElazzouziHassan"><img src="https://travis-ci.org/joemccann/dillinger.svg?branch=master" alt="Build Status"></a><br>
<strong>Free Software, Hell Yeah!</strong></p>
