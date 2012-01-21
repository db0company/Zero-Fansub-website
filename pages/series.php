<?php
	$page = PageContent::getInstance();
	$page->setTitle("S�ries");
	$page->setClass("series");

	$url = new Url();
	$vars = $url->getQueryVars();
	$useImageLists = !array_key_exists('noImage', $vars);
	if ($useImageLists) {
		$url->setQueryVar('noImage');
		$link = new Link($url, "Voir la liste sans images");
		$link->setClass('pictureSwitch');
		$page->addComponent($link);
	}
	else {
		$url->removeQueryVar('noImage');
		$link = new Link($url, "Voir la liste avec images");
		$link->setClass('pictureSwitch');
		$page->addComponent($link);
	}

	$licensedProjects = array();
	$notLicensedProjects = array();
	$allProjects = null;
	if ($_SESSION[DISPLAY_H] == true) {
		$allProjects = Project::getHentaiProjects();
	} else {
		$allProjects = Project::getNonHentaiProjects();
	}
	foreach($allProjects as $project) {
		if (!$project->isDoujin() && !$project->isHidden()) {
			if ($project->isLicensed()) {
				$licensedProjects[] = $project;
			} else {
				$notLicensedProjects[] = $project;
			}
		}
	}
	
	$page->addComponent(new Title("Non licenci�s", 2));
	
	$page->addComponent(new Title("Projets en cours", 3));
	$list = new ProjectList();
	foreach($notLicensedProjects as $project) {
		if ($project->isRunning()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);
	
	$page->addComponent(new Title("Projets termin�s", 3));
	$list = new ProjectList();
	foreach($notLicensedProjects as $project) {
		if ($project->isFinished()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);

	$page->addComponent(new Title("Projets abandonn�s", 3));
	$list = new ProjectList();
	foreach($notLicensedProjects as $project) {
		if ($project->isAbandonned()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);

	$page->addComponent(new Title("Projets envisag�s", 3));
	$list = new ProjectList();
	foreach($notLicensedProjects as $project) {
		if (!$project->isStarted() && !$project->isAbandonned()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);

	$page->addComponent(new Title("Licenci�s", 2));
	$list = new ProjectList();
	foreach($licensedProjects as $project) {
		$list->addProject($project);
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);
?>

