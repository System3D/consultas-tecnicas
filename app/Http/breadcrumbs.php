<?php
// Cliente
Breadcrumbs::register('client', function ($breadcrumbs, $client) {
	$breadcrumbs->push($client->name, url('clientes/' . $client->id));
});

// Obras
Breadcrumbs::register('projects', function ($breadcrumbs, $project) {
	$breadcrumbs->parent('client', $project->client);
	$breadcrumbs->push('Obras', url('clientes/' . $project->client_id . '#obras'));
});

// Obra X
Breadcrumbs::register('project', function ($breadcrumbs, $project) {
	$breadcrumbs->parent('client', $project->client);
	$breadcrumbs->push('Obra ' . $project->title, url('clientes/' . $project->client_id . '/obras/' . $project->id));
});

// ETAPA OBRA
Breadcrumbs::register('project_stage', function ($breadcrumbs, $project_stage) {
	$breadcrumbs->push($project_stage->project()->title, url('obras/' . $project_stage->project_id));
	$breadcrumbs->push($project_stage->title);
});
Breadcrumbs::register('project_stage_create', function ($breadcrumbs, $project) {
	$breadcrumbs->push('Obra ' . $project->title, url('obras/' . $project->id));
	$breadcrumbs->push('Nova Etapa');
});

// DISCIPLINA OBRA
Breadcrumbs::register('project_disciplines_create', function ($breadcrumbs, $project) {
	$breadcrumbs->parent('client', $project->client);
	$breadcrumbs->push('Obra ' . $project->title, url('obras/' . $project->id));
	$breadcrumbs->push('Nova Disciplina');
});

// CONSULTAS TÉCNICAS
Breadcrumbs::register('technical_consults', function ($breadcrumbs) {
	$breadcrumbs->push('Consultas Técnicas', url('consultas_tecnicas/'));
});
// CONSULTAS TÉCNICAS X
Breadcrumbs::register('technical_consult', function ($breadcrumbs, $technical_consult) {
	$breadcrumbs->parent('technical_consults', $technical_consult->client);
	$breadcrumbs->push('CT ' . str_pad($technical_consult->id, 3, "0", STR_PAD_LEFT), url('clientes/' . $technical_consult->client_id . '/obras/' . $technical_consult->id));
});
Breadcrumbs::register('technical_consults_create', function ($breadcrumbs) {
	$breadcrumbs->parent('technical_consults');
	$breadcrumbs->push('Nova Consultas Técnica');
});

// CONSULTAS TÉCNICAS
Breadcrumbs::register('consultas_tecnicas', function ($breadcrumbs, $technical_consult) {
	$breadcrumbs->parent('project', $technical_consult->project);
	// $breadcrumbs->parent('consultas_tecnicas', $technical_consult->client);
	$breadcrumbs->push('Consulta Técnica CT' . str_pad($technical_consult->id, 3, "0", STR_PAD_LEFT), url('clientes/' . $technical_consult->client_id . '/obras/' . $technical_consult->id));
});
Breadcrumbs::register('consultas_tecnicas_criar_envio', function ($breadcrumbs) {
	// $breadcrumbs->parent('project');
	$breadcrumbs->push('Nova Consulta Técnica');
});
Breadcrumbs::register('consultas_tecnicas_criar_retorno', function ($breadcrumbs) {
	// $breadcrumbs->parent('consultas_tecnicas');
	$breadcrumbs->push('Registrar Retorno');
});
Breadcrumbs::register('consultas_tecnicas_criar_evento', function ($breadcrumbs) {
	// $breadcrumbs->parent('consultas_tecnicas');
	$breadcrumbs->push('Registrar Evento');
});