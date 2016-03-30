<?php
use App\Client;
use App\Contact;
use App\EmailMessage;
use App\Helpers\Alfred;
use App\Project;
use App\ProjectDiscipline;
use App\ProjectStage;
use App\TechnicalConsult;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	public function run() {
		Model::unguard();

		$faker = Faker::create('pt_BR');
		$faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
		$faker->addProvider(new \Faker\Provider\pt_BR\Address($faker));
		// $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
		// $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
		// $faker->addProvider(new \Faker\Provider\en_US\Company($faker));
		$faker->addProvider(new \Faker\Provider\Lorem($faker));
		$faker->addProvider(new \Faker\Provider\Internet($faker));

		/*
				CREATE FAKE USERS
			 */
		foreach (range(1, 2) as $index) {

			$user = User::create([
				'username' => ($index == 1) ? env('ADMIN_USERNAME', 'tonetlds') : $faker->userName(),
				'name' => ($index == 1) ? env('ADMIN_NAME', 'Luciano') : $faker->firstName(),
				'email' => ($index == 1) ? env('ADMIN_EMAIL', 'tonetlds@gmail.com') : $faker->email(),
				'password' => ($index == 1) ? Hash::make(env('ADMIN_PASSWORD', '1234')) : Hash::make('1234'),
			]);
			echo "______________________________________________________________________________________";
			echo "\n";
			echo "User " . $index . ": #" . $user->id . " " . $user->name . "";
			echo "\n";

			/*
					Clients for each user
				 */
			foreach (range(1, 3) as $index_client) {

				$empresa = $faker->company();
				$client = new Client;
				$client->name = $empresa;
				$client->responsavel = $faker->firstName() . " " . $faker->lastName();
				$client->email = $faker->email();
				$client->email2 = $faker->email();
				$client->phones = $faker->phoneNumber() . ", " . $faker->phoneNumber();
				$client->company = $empresa;
				$client->address = $faker->streetAddress();
				$client->city = $faker->city();
				$client->cep = $faker->postcode();
				$client->obs = $faker->sentence($nbWords = 6, $variableNbWords = true);

				$slug = $client->slug;
				$client->slug = $slug;

				$client->owner_id = $user->id;

				$client->save();
				echo "Cliente " . $client->name;
				echo "\n";

				/* CONTACTS */
				foreach (range(1, 3) as $index) {
					Contact::create([
						'name' => $faker->firstName() . " " . $faker->lastName(),
						'email' => $faker->email(),
						'address' => $faker->streetAddress(),
						'company' => $faker->company(),
						'client_id' => $client->id,
						'owner_id' => $user->id,
					]);
				}

				/*
						PROJECTS
					*/
				foreach (range(1, 3) as $index_project) {

					$project = Project::create([
						'title' => $index . '-' . $faker->stateAbbr(),
						'description' => $faker->company(),
						'status' => '',
						'date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
						'client_id' => $client->id,
						'owner_id' => $user->id,
					]);

					echo "Criado projeto " . $project->id . " para " . $client->name . " (user: " . $user->id . ")";
					echo "\n";

					/* DISCIPLINAS */
					foreach (range(1, 3) as $index_discipline) {
						$items = ['Estrutura Metálica', 'Concreto', 'Instalações de Ar Condicionado', 'Segurança'];
						$disciplines = ProjectDiscipline::create([
							'title' => $items[$index_discipline - 1],
							'description' => $faker->sentence($nbWords = 6),
							'project_id' => $project->id,
							'owner_id' => $user->id,
						]);
						echo "Disciplina " . $disciplines->title;
						echo "\n";
					}

					/* ETAPAS */
					foreach (range(1, 3) as $index_stage) {
						$items = ['Geral', '1A', '1B', '2A'];
						$projectstage = ProjectStage::create([
							'title' => $index_stage . ' ' . $items[$index_stage - 1],
							'status' => 'Em andamento',
							'description' => $faker->company(),
							'project_id' => $project->id,
							'owner_id' => $user->id,
						]);
						echo "Etapa " . $projectstage->title;
						echo "\n";

						/* CONSULTAS TÉCNICAS */
						foreach (range(1, 3) as $index_consults) {
							$tc_types = array(0, 1, 2);
							$tc_type = $tc_types[array_rand($tc_types)];

							$tc_rating = array(1, 2, 3);
							$color = new Alfred;

							$consult = TechnicalConsult::create([
								'title' => 'Consulta teste ' . $index_consults . ' Projeto ' . $project->id . ' Etapa ' . $projectstage->id,
								'description' => $faker->company(),
								'cliente_id' => $project->client->id,
								'project_id' => $project->id,
								'project_stage_id' => $projectstage->id,
								'color' => $color->randomColor(),
								'owner_id' => $user->id,
							]);

							echo "Consulta tecnica '" . $consult->title . "' com 3 emails";
							echo "\n";

							/* EMAILS */
							$subjects = 'Consulta sobre ' . $faker->sentence($nbWords = 2);
							$email_message = EmailMessage::create([
								'type' => 1,
								'from' => $client->email,
								'to' => 'contato@cliente.com',
								'subject' => $subjects,
								'body_text' => 'Texto do corpo do email',
								'body_html' => '<strong>Teste</strong> de e-mail em <i>html</i> enviado para ' . $client->email . ' em ' . $consult->created_at . '.',
								'headers' => '',
								'consulta_tecnica_id' => $consult->id,
								'email_message_id' => null,
								'owner_id' => $user->id,
								'status' => null,
								'date' => $faker->dateTimeThisYear($max = 'now'),
								'rating' => $tc_rating[array_rand($tc_rating)],
							]);

							echo "E-mail enviado para <" . $email_message->to . ">";
							echo "\n";

							$email_message = EmailMessage::create([
								'type' => 2,
								'from' => 'contato@cliente.com',
								'to' => $client->email,
								'subject' => 'RE: ' . $subjects,
								'body_text' => 'Texto do corpo do segundo email',
								'body_html' => '<strong>Título</strong><p>Segundo E-mail em html enviado para ' . $client->email . '.</p>',
								'headers' => '',
								'consulta_tecnica_id' => $consult->id,
								'email_message_id' => $email_message->id,
								'owner_id' => $user->id,
								'status' => null,
								'date' => $faker->dateTimeThisYear($max = 'now'),
								'rating' => $tc_rating[array_rand($tc_rating)],
							]);

							echo "E-mail enviado para <" . $email_message->to . ">";
							echo "\n";

							$email_message = EmailMessage::create([
								'type' => $tc_type,
								'from' => 'contato@cliente.com',
								'to' => $client->email,
								'subject' => 'RE: ' . $subjects,
								'body_text' => 'Texto do corpo do segundo email',
								'body_html' => '<strong>Título</strong><p>Segundo E-mail em html enviado para ' . $client->email . '.</p>',
								'headers' => '',
								'consulta_tecnica_id' => $consult->id,
								'email_message_id' => $email_message->id,
								'owner_id' => $user->id,
								'status' => null,
								'date' => $faker->dateTimeThisYear($max = 'now'),
								'rating' => $tc_rating[array_rand($tc_rating)],
							]);

							echo "E-mail enviado para <" . $email_message->to . ">";
							echo "\n";

						}

					}

				}

			}

		}
	}
}