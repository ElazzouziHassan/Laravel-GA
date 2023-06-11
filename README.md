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
            $table-&gt;id();
            $table-&gt;string('titre', 80);
            $table-&gt;text('description')-&gt;nullable();
            $table-&gt;unsignedInteger('duree')-&gt;default(10);
            $table-&gt;unsignedInteger('difficulte');
            $table-&gt;unsignedInteger('age_max')-&gt;default(1);
            $table-&gt;timestamps();
        });
    }
</code></pre>
<h1 class="code-line" data-line-start=17 data-line-end=18 ><a id="Crer_la_factory_pour_la_table_activits_17"></a>Créer la factory pour la table “activités”:</h1>
<h2 class="code-line" data-line-start=18 data-line-end=19 ><a id="Pour_gnrer_des_donnes_fictives_pour_la_table_activits_vous_pouvez_crer_une_factory_en_utilisant_le_code_suivant_18"></a>Pour générer des données fictives pour la table “activités”, vous pouvez créer une factory en utilisant le code suivant:</h2>
<pre><code class="has-line-data" data-line-start="20" data-line-end="32" class="language-git">public function definition(): array
    {
        return [
            // instead of using regex you can use the function : title()
            'titre' =&gt; $this-&gt;faker-&gt;unique()-&gt;regexify('[A-Za-z0-9]{1,80}'),
            'description' =&gt; $this-&gt;faker-&gt;text(),
            'duree' =&gt; $this-&gt;faker-&gt;numberBetween(10),
            'difficulte' =&gt; $this-&gt;faker-&gt;numberBetween(1, 5),
            'age_max' =&gt; $this-&gt;faker-&gt;numberBetween(1, 15),
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

        \App\Models\ActivitesModel::factory(10)-&gt;create();

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
        $validatedData = $request-&gt;validate([
            'titre' =&gt; 'required|unique:activites',
            'difficulte' =&gt; 'required|integer|min:1|max:5',
            'duree' =&gt; 'required|integer|min:10',
            'age_max' =&gt; 'required|integer|min:1|max:15',
        ]);

        ActivitesModel::create($validatedData);

        return redirect()-&gt;route('index')-&gt;with('success', 'Activité ajoute avec succès.');
    }
</code></pre>
<h2 class="code-line" data-line-start=82 data-line-end=83 ><a id="b__la_fonction_update_82"></a>b - la fonction update:</h2>
<pre><code class="has-line-data" data-line-start="84" data-line-end="98" class="language-git">public function update(Request $request, ActivitesModel $activite)
    {
        $validatedData = $request-&gt;validate([
            'titre' =&gt; 'required|unique:activites,titre,' . $activite-&gt;id . '|regex:/^[A-Za-z0-9\s]+$/',
            'difficulte' =&gt; 'required|integer|min:1|max:5',
            'duree' =&gt; 'required|integer|min:10',
            'age_max' =&gt; 'required|integer|min:1|max:15',
        ]);

        $activite-&gt;update($validatedData);

        return redirect()-&gt;route('activites.index')-&gt;with('success', 'Activité mise à jour avec succès.');
    }
</code></pre>
<h2 class="code-line" data-line-start=99 data-line-end=100 ><a id="b__la_fonction_destroy_99"></a>b - la fonction destroy:</h2>
<pre><code class="has-line-data" data-line-start="101" data-line-end="108" class="language-git">public function destroy(ActivitesModel $activite)
    {
        $activite-&gt;delete();

        return redirect()-&gt;route('activites.index')-&gt;with('success', 'Activité supprimée avec succès.');
    }
</code></pre>
<h2 class="code-line" data-line-start=108 data-line-end=109 ><a id="la_vue_index__108"></a>la vue index :</h2>
<pre><code class="has-line-data" data-line-start="111" data-line-end="160" class="language-php">&lt;!DOCTYPE html&gt;
&lt;html lang=<span class="hljs-string">"en"</span>&gt;
&lt;head&gt;
  &lt;meta charset=<span class="hljs-string">"UTF-8"</span>&gt;
  &lt;meta name=<span class="hljs-string">"viewport"</span> content=<span class="hljs-string">"width=device-width, initial-scale=1.0"</span>&gt;
  &lt;meta http-equiv=<span class="hljs-string">"X-UA-Compatible"</span> content=<span class="hljs-string">"ie=edge"</span>&gt;
  &lt;title&gt;gestion des activites&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;

    &lt;h1&gt;Liste des activités&lt;/h1&gt;

    &lt;table&gt;
        &lt;thead&gt;
            &lt;tr&gt;
                &lt;th&gt;Titre&lt;/th&gt;
                &lt;th&gt;Description&lt;/th&gt;
                &lt;th&gt;Durée&lt;/th&gt;
                &lt;th&gt;Difficulté&lt;/th&gt;
                &lt;th&gt;Âge maximum&lt;/th&gt;
                &lt;th&gt;Actions&lt;/th&gt;
            &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody&gt;
            @<span class="hljs-keyword">foreach</span> (<span class="hljs-variable">$activites</span> <span class="hljs-keyword">as</span> <span class="hljs-variable">$activite</span>)
                &lt;tr&gt;
                    &lt;td&gt;{{ <span class="hljs-variable">$activite</span>-&gt;titre }}&lt;/td&gt;
                    &lt;td&gt;{{ <span class="hljs-variable">$activite</span>-&gt;description }}&lt;/td&gt;
                    &lt;td&gt;{{ <span class="hljs-variable">$activite</span>-&gt;duree }}&lt;/td&gt;
                    &lt;td&gt;{{ <span class="hljs-variable">$activite</span>-&gt;difficulte }}&lt;/td&gt;
                    &lt;td&gt;{{ <span class="hljs-variable">$activite</span>-&gt;age_max }}&lt;/td&gt;
                    &lt;td&gt;
                        &lt;a href=<span class="hljs-string">"{{ route('edit', $activite-&gt;id) }}"</span>&gt;Modifier&lt;/a&gt;
                        &lt;form action=<span class="hljs-string">"{{ route('destroy', $activite-&gt;id) }}"</span> method=<span class="hljs-string">"POST"</span>&gt;
                            @csrf
                            @method(<span class="hljs-string">'DELETE'</span>)
                            &lt;button type=<span class="hljs-string">"submit"</span>&gt;Supprimer&lt;/button&gt;
                        &lt;/form&gt;
                    &lt;/td&gt;
                &lt;/tr&gt;
            @<span class="hljs-keyword">endforeach</span>
        &lt;/tbody&gt;
    &lt;/table&gt;

    &lt;a href=<span class="hljs-string">"{{ route('create') }}"</span>&gt;Ajouter une activité&lt;/a&gt;

&lt;/body&gt;
&lt;/html&gt;
</code></pre>
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
