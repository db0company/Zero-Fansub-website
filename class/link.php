<?php
/*
	A link is a reference (URL) to another resource.
*/

class Link extends DefaultHtmlComponent {
	private $url = null;
	private $title = null;
	private $newWindow = null;
	private $onClick = null;
	
	public function __construct($url = null, $content = null) {
		if ($url == null) {
			$url = new Url();
		}
		if (is_string($url)) {
			$url = new Url($url);
		}
		$this->url = $url;
		if ($content instanceof IHtmlComponent) {
			$this->addComponent($content);
		}
		else {
			$this->setContent($content === null ? $url->toString() : $content);
		}
	}
	
	public function openNewWindow($boolean) {
		$this->newWindow = $boolean;
	}
	
	public function getHtmlTag() {
		return 'a';
	}
	
	public function setUrl(Url $url) {
		$this->url = $url;
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	public function setOnClick($javascript) {
		$this->onClick = $javascript;
	}
	
	public function getOnClick() {
		return $this->onClick;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getOptions() {
		$url = $this->getUrl()->toString();
		$title = $this->getTitle();
		$onClick = $this->getOnClick();
		$newWindow = $this->newWindow;
		$urlPart = $url === null ? '' : ' href="'.$url.'"';
		$titlePart = $title === null ? '' : ' title="'.$title.'"';
		$onClickPart = $onClick === null ? '' : ' onclick="'.$onClick.'"';
		$targetPart = $newWindow === true ? ' target="_blank"' : '';
		return parent::getOptions().$urlPart.$titlePart.$targetPart.$onClickPart;
	}
	
	public static function newWindowLink($url = null, $content = null) {
		$link = new Link($url, $content);
		$link->openNewWindow(true);
		return $link;
	}
	
	public static function CreateHentaiAccessLink($toHentaiString = "Henta�", $toEveryoneString = "Tout public") {
		$hentaiLink = new Link();
		$url = $hentaiLink->getUrl();
		if ($_SESSION[DISPLAY_H] == false) {
			$url->setQueryVar(DISPLAY_H_AVERT);
			$hentaiLink->setContent($toHentaiString);
		} else {
			$url->setQueryVar(DISPLAY_H, false);
			$hentaiLink->setContent($toEveryoneString);
		}
		return $hentaiLink;
	}
}
?>
